<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

/**
 * Impor massal peserta dari berkas Excel.
 *
 * Tahun ajar dipilih sekali di form unggah dan berlaku untuk seluruh baris;
 * program studi dan gelombang diisi per baris di berkasnya.
 */
class ImporPesertaTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $super = null;
    protected Prodi $prodi;
    protected TahunAjar $ganjil;
    protected TahunAjar $genap;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prodi = Prodi::create(['nama_prodi' => 'Akuntansi']);
        Prodi::create(['nama_prodi' => 'Informatika']);

        $this->ganjil = TahunAjar::create([
            'tahun_ajar' => '2026/2027', 'ganjil_genap' => 'ganjil', 'nominal_cashback' => 0,
        ]);
        $this->genap = TahunAjar::create([
            'tahun_ajar' => '2026/2027', 'ganjil_genap' => 'genap', 'nominal_cashback' => 100000,
        ]);
    }

    protected function superadmin(): User
    {
        return $this->super ??= User::factory()->create([
            'role' => 'superadmin', 'nama' => 'Super', 'email' => 'super@unsia.my.id',
        ]);
    }

    /**
     * Membuat berkas .xlsx dengan header template dan baris yang diberikan.
     *
     * @param  list<array<int, string>>  $baris
     */
    protected function berkas(array $baris, array $header = null): UploadedFile
    {
        $header ??= ['NIM', 'Nama Lengkap', 'Email (opsional)', 'Program Studi', 'Gelombang', 'Password (opsional)'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($header, null, 'A1');
        $sheet->fromArray($baris, null, 'A2');

        $path = tempnam(sys_get_temp_dir(), 'impor').'.xlsx';
        (new Xlsx($spreadsheet))->save($path);

        return new UploadedFile($path, 'peserta.xlsx', null, null, true);
    }

    protected function unggah(UploadedFile $berkas, ?int $tahunAjarId = null)
    {
        return $this->actingAs($this->superadmin())
            ->post(route('admin.users.import.store'), [
                'file' => $berkas,
                'tahun_ajar_id' => $tahunAjarId ?? $this->genap->id,
            ]);
    }

    public function test_peserta_terimpor_dengan_tahun_ajar_dari_form(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi Santoso', 'budi@contoh.id', 'Akuntansi', '3', ''],
            ['2202222222', 'Siti Aminah', 'siti@contoh.id', 'Informatika', '3', ''],
        ]));

        $this->assertDatabaseCount('users', 3); // 2 peserta + superadmin

        $this->assertDatabaseHas('users', [
            'nim' => '2201111111',
            'role' => 'mahasiswa',
            'tahun_ajar_id' => $this->genap->id,
            'gelombang' => 3,
        ]);
    }

    /**
     * Inti perubahannya: periode TIDAK diambil dari berkas, tapi dari pilihan
     * di form — sehingga seluruh baris pasti masuk ke periode yang sama.
     */
    public function test_seluruh_baris_memakai_periode_yang_dipilih(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', '1', ''],
            ['2202222222', 'Siti', 'siti@contoh.id', 'Akuntansi', '5', ''],
            ['2203333333', 'Andi', 'andi@contoh.id', 'Informatika', '2', ''],
        ]), $this->ganjil->id);

        $periode = User::mahasiswa()->pluck('tahun_ajar_id')->unique();

        $this->assertCount(1, $periode);
        $this->assertSame($this->ganjil->id, $periode->first());
    }

    public function test_kolom_tahun_ajar_di_berkas_diabaikan(): void
    {
        // Berkas lama yang masih memuat kolom Tahun Ajar tidak boleh membuat
        // sebagian peserta masuk ke periode yang berbeda dari pilihan admin.
        $berkas = $this->berkas(
            [['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', '2026/2027 Ganjil', '3', '']],
            ['NIM', 'Nama Lengkap', 'Email (opsional)', 'Program Studi', 'Tahun Ajar', 'Gelombang', 'Password (opsional)']
        );

        $this->unggah($berkas, $this->genap->id);

        $this->assertDatabaseHas('users', [
            'nim' => '2201111111',
            'tahun_ajar_id' => $this->genap->id,
        ]);
    }

    public function test_tahun_ajar_wajib_dipilih(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.import.store'), [
                'file' => $this->berkas([['2201111111', 'Budi', '', 'Akuntansi', '3', '']]),
            ])
            ->assertSessionHasErrors('tahun_ajar_id');

        $this->assertDatabaseCount('users', 1); // hanya superadmin
    }

    public function test_prodi_dicocokkan_dari_namanya_tanpa_peduli_huruf_besar(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'akuntansi', '1', ''],
            ['2202222222', 'Siti', 'siti@contoh.id', 'INFORMATIKA', '1', ''],
        ]));

        $this->assertDatabaseHas('users', ['nim' => '2201111111', 'prodi_id' => $this->prodi->id]);
        $this->assertDatabaseHas('users', [
            'nim' => '2202222222',
            'prodi_id' => Prodi::where('nama_prodi', 'Informatika')->value('id'),
        ]);
    }

    public function test_prodi_tak_dikenal_membatalkan_seluruh_impor(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', '1', ''],
            ['2202222222', 'Siti', 'siti@contoh.id', 'Teknik Mesin', '1', ''],
        ]))->assertSessionHas('importErrors');

        // Semua-atau-tidak: baris pertama yang benar pun tidak tersimpan.
        $this->assertDatabaseCount('users', 1);
    }

    public function test_gelombang_di_luar_rentang_membatalkan_impor(): void
    {
        $maks = (int) config('pendaftaran.gelombang_maksimal');

        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', (string) ($maks + 1), ''],
        ]))->assertSessionHas('importErrors');

        $this->assertDatabaseCount('users', 1);
    }

    public function test_gelombang_boleh_ditulis_dengan_kata(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', 'Gelombang 4', ''],
        ]));

        $this->assertDatabaseHas('users', ['nim' => '2201111111', 'gelombang' => 4]);
    }

    public function test_nim_kembar_di_dalam_berkas_ditolak(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', '1', ''],
            ['2201111111', 'Siti', 'siti@contoh.id', 'Akuntansi', '1', ''],
        ]))->assertSessionHas('importErrors');

        $this->assertDatabaseCount('users', 1);
    }

    /**
     * Impor dulu meng-hash password untuk SETIAP baris. Bcrypt sengaja lambat
     * (~0,3 detik per hash), sehingga impor 200 baris melewati batas waktu PHP
     * dan berakhir sebagai 500 tanpa pesan apa pun di log Laravel.
     *
     * Kini baris tanpa password memakai satu hash bersama, jadi jumlah baris
     * tidak lagi menentukan lamanya.
     */
    public function test_impor_banyak_baris_tidak_melambat_karena_hashing(): void
    {
        $baris = [];
        for ($i = 1; $i <= 150; $i++) {
            $baris[] = ['22' . str_pad((string) $i, 8, '0', STR_PAD_LEFT), "Peserta $i", '', 'Akuntansi', '1', ''];
        }

        $this->unggah($this->berkas($baris));

        $this->assertSame(150, User::mahasiswa()->count());

        // Diperiksa dari struktur, bukan dari lama waktunya. Pengujian memakai
        // BCRYPT_ROUNDS=4 sementara produksi 12, sehingga ukuran waktu di sini
        // tidak mewakili apa pun — pengukuran waktu sempat membuat tes ini
        // lolos meski hashing per baris dikembalikan.
        //
        // Satu hash yang dipakai bersama persis itulah yang membuat jumlah
        // baris tidak lagi menentukan lamanya proses.
        $hashUnik = User::mahasiswa()->pluck('password')->unique();

        $this->assertCount(1, $hashUnik,
            'Baris tanpa password harus berbagi satu hash; '.$hashUnik->count().' hash berbeda ditemukan');
    }

    /**
     * Baris tanpa password tidak boleh bisa dipakai masuk dengan NIM-nya,
     * seperti perilaku lama. Pemiliknya harus lewat menu "Buat Akun".
     */
    public function test_baris_tanpa_password_tidak_bisa_login_dengan_nim(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', '1', ''],
        ]));

        $user = User::where('nim', '2201111111')->firstOrFail();

        $this->assertFalse(\Illuminate\Support\Facades\Hash::check('2201111111', $user->password));
        $this->assertNull($user->terakhir_login_pada);
    }

    public function test_password_yang_diisi_admin_tetap_berlaku(): void
    {
        $this->unggah($this->berkas([
            ['2201111111', 'Budi', 'budi@contoh.id', 'Akuntansi', '1', 'rahasia123'],
        ]));

        $user = User::where('nim', '2201111111')->firstOrFail();

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('rahasia123', $user->password));
    }

    /**
     * Kalau kolom Password diisi untuk terlalu banyak baris, impor ditolak
     * dengan pesan yang jelas — bukan berhenti di tengah sebagai 500.
     */
    public function test_password_diisi_terlalu_banyak_ditolak_dengan_pesan(): void
    {
        // Batas waktu dibuat kecil supaya ambangnya ikut kecil dan tesnya cepat.
        $asli = ini_get('max_execution_time');
        ini_set('max_execution_time', '6');

        $baris = [];
        for ($i = 1; $i <= 20; $i++) {
            $baris[] = ['22' . str_pad((string) $i, 8, '0', STR_PAD_LEFT), "P$i", '', 'Akuntansi', '1', 'rahasia123'];
        }

        $this->unggah($this->berkas($baris))
            ->assertSessionHas('error', fn ($p) => str_contains($p, 'Kosongkan kolom Password'));

        $this->assertSame(0, User::mahasiswa()->count());

        ini_set('max_execution_time', (string) $asli);
    }

    public function test_hanya_superadmin_yang_boleh_mengimpor(): void
    {
        foreach (['admin', 'mahasiswa', 'downline'] as $i => $role) {
            $user = User::factory()->create(['role' => $role, 'email' => "x$i@contoh.id"]);

            $this->actingAs($user)
                ->post(route('admin.users.import.store'), [
                    'file' => $this->berkas([['220111111'.$i, 'X', '', 'Akuntansi', '1', '']]),
                    'tahun_ajar_id' => $this->genap->id,
                ])
                ->assertRedirect();
        }

        $this->assertSame(0, User::mahasiswa()->whereNotNull('tahun_ajar_id')->count());
    }

    public function test_form_impor_menampilkan_pilihan_tahun_ajar(): void
    {
        $this->actingAs($this->superadmin())
            ->get(route('admin.users.import'))
            ->assertStatus(200)
            ->assertSee('name="tahun_ajar_id"', false)
            ->assertSee($this->genap->label)
            ->assertSee($this->ganjil->label);
    }
}
