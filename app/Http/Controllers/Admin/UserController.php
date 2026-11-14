<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Downline;
use App\Models\DownlineSocialMedia;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['prodi', 'tahunAjar', 'downline'])
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->when($request->filled('prodi_id'), fn ($q) => $q->where('prodi_id', $request->prodi_id))
            ->when($request->filled('q'), function ($q) use ($request) {
                $cari = '%' . $request->q . '%';
                $q->where(fn ($sub) => $sub->where('nama', 'like', $cari)
                    ->orWhere('name', 'like', $cari)
                    ->orWhere('nim', 'like', $cari)
                    ->orWhere('email', 'like', $cari)
                    // Supaya downline bisa dicari dari ID atau kodenya.
                    ->orWhereHas('downline', fn ($d) => $d
                        ->where('id_downline', 'like', $cari)
                        ->orWhere('kode_downline', 'like', $cari)));
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'prodiList' => Prodi::orderBy('nama_prodi')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', $this->formData());
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->rules($request) + ['password' => 'required|string|min:8|confirmed'],
            $this->messages(),
            $this->attributes()
        );

        $user = User::create($this->normalize($validated));

        $this->sinkronkanDownline($user, $validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $user->load('downline.socialMedia');

        return view('admin.users.edit', $this->formData() + ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            $this->rules($request, $user) + ['password' => 'nullable|string|min:8|confirmed'],
            $this->messages(),
            $this->attributes()
        );

        // Superadmin terakhir tidak boleh diturunkan, nanti tidak ada lagi yang
        // bisa mengelola pengguna dan panel terkunci selamanya.
        if ($user->isSuperadmin() && $validated['role'] !== 'superadmin'
            && User::where('role', 'superadmin')->count() <= 1) {
            return back()->withInput()
                ->withErrors(['role' => 'Ini satu-satunya Super Admin, rolenya tidak bisa diturunkan.']);
        }

        $data = $this->normalize($validated);

        // Password kosong berarti tidak diganti.
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        $this->sinkronkanDownline($user, $validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if ($user->isSuperadmin() && User::where('role', 'superadmin')->count() <= 1) {
            return back()->with('error', 'Super Admin terakhir tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Data prodi & tahun ajar untuk dropdown form.
     */
    protected function formData(): array
    {
        return [
            'prodiList' => Prodi::orderBy('nama_prodi')->get(),
            'tahunAjarList' => TahunAjar::orderByDesc('tahun_ajar')->orderBy('ganjil_genap')->get(),
        ];
    }

    /**
     * Kewajiban field bergantung role:
     *
     * superadmin / admin : email (untuk login)
     * downline           : email (untuk login) + kode referal
     * mahasiswa          : NIM, prodi, tahun ajar — emailnya opsional
     *
     * Kode referal tetap boleh diisi role lain, hanya tidak diwajibkan.
     */
    protected function rules(Request $request, ?User $user = null): array
    {
        $role = $request->input('role');

        // Downline tidak punya NIM, jadi ia masuk memakai email seperti
        // pengelola — walau ia tidak punya akses panel.
        $pakaiEmail = in_array($role, User::ROLE_LOGIN_EMAIL, true);

        // Hanya mahasiswa yang menyimpan data akademik.
        $isMahasiswa = $role === 'mahasiswa';

        return [
            'role' => ['required', Rule::in(User::ROLE_SEMUA)],
            'nama' => ['required', 'string', 'max:255'],

            'email' => [
                $pakaiEmail ? 'required' : 'nullable',
                'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],

            'nim' => [
                $isMahasiswa ? 'required' : 'nullable',
                'string', 'max:20',
                Rule::unique('users', 'nim')->ignore($user),
            ],

            'prodi_id' => [$isMahasiswa ? 'required' : 'nullable', 'exists:prodi,id'],
            'tahun_ajar_id' => [$isMahasiswa ? 'required' : 'nullable', 'exists:tahun_ajar,id'],

            // ID dan kode downline digenerate sistem, jadi yang diisi admin
            // hanya statusnya.
            'status_downline' => [
                $role === 'downline' ? 'required' : 'nullable',
                Rule::in(Downline::STATUS),
            ],

            // Baris sosial media. Platform selalu terkirim karena berupa
            // dropdown; baris yang akunnya dibiarkan kosong dianggap batal dan
            // dibuang di sinkronkanSocialMedia().
            'social_media' => ['nullable', 'array'],
            'social_media.*.platform' => ['required', Rule::in(DownlineSocialMedia::platformYangSah())],
            'social_media.*.akun' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Hanya mahasiswa yang menyimpan data akademik. Pengelola dan downline
     * dikosongkan, supaya tidak ada sisa NIM atau prodi yang tertinggal saat
     * sebuah akun diubah rolenya dari mahasiswa.
     *
     * Kode referal sengaja tidak dikosongkan: ia opsional bagi role lain,
     * jadi nilainya dibiarkan apa adanya.
     *
     * `name` ikut diisi karena dipakai Laravel auth dan topbar admin.
     */
    protected function normalize(array $data): array
    {
        if ($data['role'] !== 'mahasiswa') {
            $data['nim'] = null;
            $data['prodi_id'] = null;
            $data['tahun_ajar_id'] = null;
        }

        $data['name'] = $data['nama'];

        // Bukan kolom di tabel users; ditangani sinkronkanDownline() dan
        // sinkronkanSocialMedia().
        unset($data['status_downline'], $data['social_media']);

        return $data;
    }

    /**
     * Menyelaraskan baris di tabel downlines dengan role akun.
     *
     * Saat sebuah akun berhenti menjadi downline, barisnya tidak dihapus
     * melainkan dinonaktifkan. Dengan begitu id_downline dan kodenya tetap
     * sama kalau kelak ia diaktifkan lagi — penting karena angka itu mungkin
     * sudah tersebar ke calon pendaftar.
     */
    protected function sinkronkanDownline(User $user, array $data): void
    {
        // Diambil langsung dari database, bukan dari relasi yang mungkin sudah
        // ter-cache sebelum role-nya berubah.
        $downline = $user->downline()->first();

        if ($data['role'] === 'downline') {
            $status = $data['status_downline'] ?? 'aktif';

            if ($downline) {
                $downline->update(['status' => $status]);
            } else {
                $downline = Downline::buatUntuk($user, $status);
            }

            $this->sinkronkanSocialMedia($downline, $data['social_media'] ?? []);

            return;
        }

        // Sosial media sengaja tidak dihapus di sini. Kalau akun ini kelak jadi
        // downline lagi, catatannya masih utuh — sejalan dengan id_downline
        // yang juga dipertahankan.
        $downline?->update(['status' => 'tidak_aktif']);
    }

    /**
     * Menyelaraskan daftar sosial media downline dengan isian form.
     *
     * Baris yang isinya sama persis dipertahankan apa adanya, supaya tanggal
     * pencatatannya tidak ikut berubah setiap kali form disimpan. Yang hilang
     * dari form dihapus, yang baru ditambahkan.
     */
    protected function sinkronkanSocialMedia(Downline $downline, array $baris): void
    {
        $diminta = [];

        foreach ($baris as $b) {
            $platform = $b['platform'] ?? null;
            $akun = DownlineSocialMedia::rapikanAkun($platform ?? '', $b['akun'] ?? '');

            // Baris kosong berarti admin tidak mengisinya; bukan error.
            if ($platform === null || $akun === '') {
                continue;
            }

            // Dikunci per platform+akun agar baris kembar yang diisi dua kali
            // tidak menabrak indeks unique.
            $diminta[$platform . '|' . mb_strtolower($akun)] = [
                'platform' => $platform,
                'akun' => $akun,
            ];
        }

        $adaSekarang = $downline->socialMedia()->get()
            ->keyBy(fn ($m) => $m->platform . '|' . mb_strtolower($m->akun));

        $dihapus = $adaSekarang->reject(fn ($m, $kunci) => isset($diminta[$kunci]));

        if ($dihapus->isNotEmpty()) {
            $downline->socialMedia()->whereIn('id', $dihapus->pluck('id')->all())->delete();
        }

        foreach (array_diff_key($diminta, $adaSekarang->all()) as $row) {
            $downline->socialMedia()->create($row);
        }
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Akun admin, super admin, dan downline wajib punya email, karena loginnya memakai email.',
            'nim.required' => 'Akun mahasiswa wajib punya NIM, karena login mahasiswa memakai NIM.',
            'prodi_id.required' => 'Program studi wajib dipilih untuk akun mahasiswa.',
            'tahun_ajar_id.required' => 'Tahun ajar wajib dipilih untuk akun mahasiswa.',
            'status_downline.required' => 'Status downline (aktif / tidak aktif) wajib dipilih.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }

    protected function attributes(): array
    {
        return [
            'nim' => 'NIM',
            'prodi_id' => 'program studi',
            'tahun_ajar_id' => 'tahun ajar',
            'status_downline' => 'status downline',
        ];
    }
}
