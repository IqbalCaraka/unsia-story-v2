<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Gelombang pendaftaran mahasiswa.
 *
 * Tahun ajar saja belum cukup mengenali kapan seorang mahasiswa mendaftar:
 * satu periode dibuka dalam beberapa gelombang.
 */
class GelombangTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $super = null;
    protected Prodi $prodi;
    protected TahunAjar $periode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prodi = Prodi::create(['nama_prodi' => 'Akuntansi']);
        $this->periode = TahunAjar::create([
            'tahun_ajar' => '2026/2027', 'ganjil_genap' => 'genap', 'nominal_cashback' => 100000,
        ]);
    }

    protected function superadmin(): User
    {
        return $this->super ??= User::factory()->create([
            'role' => 'superadmin', 'nama' => 'Super', 'email' => 'super@unsia.my.id',
        ]);
    }

    protected function dataMahasiswa(array $ganti = []): array
    {
        return array_merge([
            'nama' => 'Budi Santoso',
            'role' => 'mahasiswa',
            'nim' => '2201234567',
            'email' => null,
            'prodi_id' => $this->prodi->id,
            'tahun_ajar_id' => $this->periode->id,
            'gelombang' => 3,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ], $ganti);
    }

    public function test_gelombang_tersimpan_untuk_mahasiswa(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataMahasiswa())
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'nim' => '2201234567',
            'gelombang' => 3,
            'tahun_ajar_id' => $this->periode->id,
        ]);
    }

    public function test_gelombang_wajib_untuk_mahasiswa(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataMahasiswa(['gelombang' => null]))
            ->assertSessionHasErrors('gelombang');
    }

    public function test_gelombang_di_luar_rentang_ditolak(): void
    {
        $maks = (int) config('pendaftaran.gelombang_maksimal');

        foreach ([0, -1, $maks + 1, 99] as $nilai) {
            $this->actingAs($this->superadmin())
                ->post(route('admin.users.store'), $this->dataMahasiswa(['gelombang' => $nilai]))
                ->assertSessionHasErrors('gelombang');
        }
    }

    public function test_batas_gelombang_mengikuti_config(): void
    {
        config(['pendaftaran.gelombang_maksimal' => 4]);

        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataMahasiswa(['gelombang' => 5]))
            ->assertSessionHasErrors('gelombang');

        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataMahasiswa(['gelombang' => 4]))
            ->assertSessionHasNoErrors();
    }

    /**
     * Role selain mahasiswa tidak menyimpan data akademik, termasuk gelombang.
     */
    public function test_gelombang_dikosongkan_untuk_role_lain(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataMahasiswa([
                'role' => 'admin',
                'nim' => null,
                'email' => 'admin2@unsia.my.id',
                'gelombang' => 3,
            ]))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', ['email' => 'admin2@unsia.my.id', 'gelombang' => null]);
    }

    public function test_gelombang_dikosongkan_saat_mahasiswa_jadi_downline(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataMahasiswa());

        $user = User::where('nim', '2201234567')->firstOrFail();
        $this->assertSame(3, $user->gelombang);

        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $user), [
                'nama' => 'Budi Santoso',
                'role' => 'downline',
                'email' => 'budi@contoh.id',
                'status_downline' => 'aktif',
            ])
            ->assertSessionHasNoErrors();

        $this->assertNull($user->fresh()->gelombang);
    }

    public function test_periode_masuk_menggabungkan_gelombang_dan_tahun_ajar(): void
    {
        $user = User::factory()->create([
            'role' => 'mahasiswa',
            'nim' => '2209999999',
            'email' => null,
            'prodi_id' => $this->prodi->id,
            'tahun_ajar_id' => $this->periode->id,
            'gelombang' => 3,
        ]);

        $this->assertSame('Gelombang 3, 2026/2027 Genap', $user->periodeMasuk());
    }

    public function test_periode_masuk_tidak_pincang_saat_salah_satunya_kosong(): void
    {
        $tanpaGelombang = User::factory()->create([
            'role' => 'mahasiswa', 'nim' => '2208888888', 'email' => null,
            'tahun_ajar_id' => $this->periode->id, 'gelombang' => null,
        ]);

        $kosong = User::factory()->create(['role' => 'admin', 'tahun_ajar_id' => null, 'gelombang' => null]);

        $this->assertSame('2026/2027 Genap', $tanpaGelombang->periodeMasuk());
        $this->assertSame('—', $kosong->periodeMasuk());
    }

    public function test_form_menampilkan_pilihan_gelombang(): void
    {
        $maks = (int) config('pendaftaran.gelombang_maksimal');

        $response = $this->actingAs($this->superadmin())
            ->get(route('admin.users.create'))
            ->assertStatus(200)
            ->assertSee('name="gelombang"', false)
            ->assertSee('Gelombang Pendaftaran');

        for ($g = 1; $g <= $maks; $g++) {
            $response->assertSee('value="'.$g.'"', false);
        }
    }

    public function test_daftar_pengguna_menampilkan_gelombang(): void
    {
        User::factory()->create([
            'role' => 'mahasiswa', 'nama' => 'Budi Santoso', 'nim' => '2207777777',
            'email' => null, 'prodi_id' => $this->prodi->id,
            'tahun_ajar_id' => $this->periode->id, 'gelombang' => 7,
        ]);

        $this->actingAs($this->superadmin())
            ->get(route('admin.users.index', ['role' => 'mahasiswa']))
            ->assertStatus(200)
            ->assertSee('Gelombang 7');
    }

    /** Template impor harus memuat kolom gelombang. */
    public function test_template_impor_punya_kolom_gelombang(): void
    {
        $isi = $this->actingAs($this->superadmin())
            ->get(route('admin.users.import.template'))
            ->assertStatus(200)
            ->streamedContent();

        $berkas = tempnam(sys_get_temp_dir(), 'tpl').'.xlsx';
        file_put_contents($berkas, $isi);

        $sheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($berkas)->getSheet(0);

        $judul = [];
        foreach (range('A', 'G') as $kolom) {
            $judul[] = (string) $sheet->getCell($kolom.'1')->getValue();
        }

        @unlink($berkas);

        $this->assertContains('Gelombang', $judul);
        $this->assertSame('Password (opsional)', end($judul), 'Gelombang harus sebelum password');
    }
}
