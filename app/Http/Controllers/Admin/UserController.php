<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['prodi', 'tahunAjar'])
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->when($request->filled('prodi_id'), fn ($q) => $q->where('prodi_id', $request->prodi_id))
            ->when($request->filled('q'), function ($q) use ($request) {
                $cari = '%' . $request->q . '%';
                $q->where(fn ($sub) => $sub->where('nama', 'like', $cari)
                    ->orWhere('name', 'like', $cari)
                    ->orWhere('nim', 'like', $cari)
                    ->orWhere('email', 'like', $cari));
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

        User::create($this->normalize($validated));

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', $this->formData() + ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            $this->rules($request, $user) + ['password' => 'nullable|string|min:8|confirmed'],
            $this->messages(),
            $this->attributes()
        );

        // Admin terakhir tidak boleh diturunkan jadi mahasiswa, nanti panel terkunci.
        if ($user->isAdmin() && $validated['role'] !== 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withInput()
                ->withErrors(['role' => 'Ini satu-satunya akun admin, rolenya tidak bisa diubah.']);
        }

        $data = $this->normalize($validated);

        // Password kosong berarti tidak diganti.
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Akun admin terakhir tidak bisa dihapus.');
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
     * Untuk role admin, field akademik (nim, prodi, tahun ajar) tidak wajib.
     * Untuk mahasiswa wajib, dan email justru yang opsional.
     */
    protected function rules(Request $request, ?User $user = null): array
    {
        $isAdmin = $request->input('role') === 'admin';

        return [
            'role' => ['required', Rule::in(['admin', 'mahasiswa'])],
            'nama' => ['required', 'string', 'max:255'],

            'email' => [
                $isAdmin ? 'required' : 'nullable',
                'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],

            'nim' => [
                $isAdmin ? 'nullable' : 'required',
                'string', 'max:20',
                Rule::unique('users', 'nim')->ignore($user),
            ],

            'prodi_id' => [$isAdmin ? 'nullable' : 'required', 'exists:prodi,id'],
            'tahun_ajar_id' => [$isAdmin ? 'nullable' : 'required', 'exists:tahun_ajar,id'],
        ];
    }

    /**
     * Role admin tidak menyimpan data akademik; role mahasiswa login pakai NIM.
     * `name` ikut diisi karena dipakai Laravel auth dan topbar admin.
     */
    protected function normalize(array $data): array
    {
        if ($data['role'] === 'admin') {
            $data['nim'] = null;
            $data['prodi_id'] = null;
            $data['tahun_ajar_id'] = null;
        }

        $data['name'] = $data['nama'];

        return $data;
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Akun admin wajib punya email, karena login admin memakai email.',
            'nim.required' => 'Akun mahasiswa wajib punya NIM, karena login mahasiswa memakai NIM.',
            'prodi_id.required' => 'Program studi wajib dipilih untuk akun mahasiswa.',
            'tahun_ajar_id.required' => 'Tahun ajar wajib dipilih untuk akun mahasiswa.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }

    protected function attributes(): array
    {
        return [
            'nim' => 'NIM',
            'prodi_id' => 'program studi',
            'tahun_ajar_id' => 'tahun ajar',
        ];
    }
}
