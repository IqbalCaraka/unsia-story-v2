<?php

namespace Tests\Feature;

use App\Models\PengajuanCashback;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cashback adalah manfaat sekali seumur, bukan per periode: ia melekat pada
 * pemakaian kode referal saat mendaftar, dan itu terjadi satu kali.
 *
 * Sebelumnya pembatasannya per periode, sehingga mahasiswa yang klaimnya sudah
 * disetujui di satu periode masih bisa mengajukan lagi di periode berikutnya.
 */
class CashbackSekaliTest extends TestCase
{
    use RefreshDatabase;

    protected TahunAjar $ganjil;
    protected TahunAjar $genap;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ganjil = TahunAjar::create([
            'tahun_ajar' => '2026/2027', 'ganjil_genap' => 'ganjil', 'nominal_cashback' => 100000,
        ]);

        $this->genap = TahunAjar::create([
            'tahun_ajar' => '2026/2027', 'ganjil_genap' => 'genap', 'nominal_cashback' => 100000,
        ]);
    }

    protected function mahasiswa(): User
    {
        return User::factory()->create([
            'role' => 'mahasiswa',
            'nama' => 'Budi',
            'nim' => '2200000001',
            'email' => null,
            'prodi_id' => Prodi::create(['nama_prodi' => 'Akuntansi'])->id,
            'tahun_ajar_id' => $this->ganjil->id,
        ]);
    }

    protected function dataPengajuan(TahunAjar $periode): array
    {
        return [
            'tahun_ajar_id' => $periode->id,
            'metode' => 'ewallet',
            'penyedia' => 'GoPay',
            'nomor' => '081200000001',
            'atas_nama' => 'Budi',
        ];
    }

    public function test_mahasiswa_yang_belum_pernah_bisa_mengajukan(): void
    {
        $user = $this->mahasiswa();

        $this->actingAs($user)
            ->post(route('cashback.store'), $this->dataPengajuan($this->ganjil))
            ->assertRedirect(route('cashback.index'));

        $this->assertDatabaseHas('pengajuan_cashback', [
            'user_id' => $user->id,
            'status' => 'menunggu',
        ]);
    }

    public function test_tidak_bisa_mengajukan_lagi_saat_masih_diproses(): void
    {
        $user = $this->mahasiswa();

        $this->actingAs($user)->post(route('cashback.store'), $this->dataPengajuan($this->ganjil));

        // Periode berbeda pun tetap ditahan.
        $this->actingAs($user)
            ->post(route('cashback.store'), $this->dataPengajuan($this->genap))
            ->assertSessionHas('error', fn ($p) => str_contains($p, 'sedang diproses'));

        $this->assertSame(1, PengajuanCashback::where('user_id', $user->id)->count());
    }

    /**
     * Inti permintaannya: sekali disetujui, fitur terkunci — termasuk untuk
     * periode lain yang cashback-nya terbuka.
     */
    public function test_terkunci_setelah_klaim_disetujui(): void
    {
        $user = $this->mahasiswa();

        PengajuanCashback::create($this->dataPengajuan($this->ganjil) + [
            'user_id' => $user->id,
            'jumlah' => 100000,
            'status' => 'diverifikasi',
        ]);

        // Pesannya ikut diperiksa: ia membedakan "sudah disetujui" dari
        // "sedang diproses", dan itu satu-satunya hal yang membedakan kedua
        // pemeriksaan di controller.
        $this->actingAs($user)
            ->post(route('cashback.store'), $this->dataPengajuan($this->genap))
            ->assertSessionHas('error', fn ($p) => str_contains($p, 'sudah disetujui'));

        $this->assertSame(1, PengajuanCashback::where('user_id', $user->id)->count());
    }

    public function test_terkunci_juga_setelah_dibayar(): void
    {
        $user = $this->mahasiswa();

        PengajuanCashback::create($this->dataPengajuan($this->ganjil) + [
            'user_id' => $user->id,
            'jumlah' => 100000,
            'status' => 'dibayar',
        ]);

        $this->actingAs($user)
            ->post(route('cashback.store'), $this->dataPengajuan($this->genap))
            ->assertSessionHas('error', fn ($p) => str_contains($p, 'sudah disetujui'));

        $this->assertSame(1, PengajuanCashback::where('user_id', $user->id)->count());
    }

    /**
     * Klaim yang ditolak bukan klaim yang disetujui, jadi tidak mengunci.
     */
    public function test_klaim_yang_ditolak_tidak_mengunci(): void
    {
        $user = $this->mahasiswa();

        PengajuanCashback::create($this->dataPengajuan($this->ganjil) + [
            'user_id' => $user->id,
            'jumlah' => 100000,
            'status' => 'ditolak',
        ]);

        $this->actingAs($user)
            ->post(route('cashback.store'), $this->dataPengajuan($this->ganjil))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('cashback.index'));

        $this->assertSame(2, PengajuanCashback::where('user_id', $user->id)->count());
    }

    public function test_halaman_menyembunyikan_formulir_saat_terkunci(): void
    {
        $user = $this->mahasiswa();

        PengajuanCashback::create($this->dataPengajuan($this->ganjil) + [
            'user_id' => $user->id,
            'jumlah' => 100000,
            'status' => 'dibayar',
        ]);

        $this->actingAs($user)
            ->get(route('cashback.index'))
            ->assertStatus(200)
            ->assertSee('Cashback Anda sudah disetujui')
            // Formulirnya tidak ditampilkan, bukan hanya ditolak saat dikirim.
            ->assertDontSee('name="atas_nama"', false);
    }

    public function test_halaman_memberi_tahu_saat_masih_diproses(): void
    {
        $user = $this->mahasiswa();

        PengajuanCashback::create($this->dataPengajuan($this->ganjil) + [
            'user_id' => $user->id,
            'jumlah' => 100000,
            'status' => 'menunggu',
        ]);

        $this->actingAs($user)
            ->get(route('cashback.index'))
            ->assertStatus(200)
            ->assertSee('sedang diproses')
            ->assertDontSee('name="atas_nama"', false);
    }

    public function test_formulir_tampil_untuk_yang_belum_pernah(): void
    {
        $this->actingAs($this->mahasiswa())
            ->get(route('cashback.index'))
            ->assertStatus(200)
            ->assertSee('name="atas_nama"', false);
    }

    public function test_downline_dan_admin_tidak_bisa_mengajukan(): void
    {
        foreach (['downline', 'admin', 'superadmin'] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->post(route('cashback.store'), $this->dataPengajuan($this->ganjil))
                ->assertStatus(403);
        }
    }
}
