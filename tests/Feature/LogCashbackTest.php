<?php

namespace Tests\Feature;

use App\Models\LogCashback;
use App\Models\PengajuanCashback;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LogCashbackTest extends TestCase
{
    use RefreshDatabase;

    protected TahunAjar $periode;
    protected ?User $admin = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->periode = TahunAjar::create([
            'tahun_ajar' => '2026/2027', 'ganjil_genap' => 'genap', 'nominal_cashback' => 100000,
        ]);
    }

    protected function admin(): User
    {
        return $this->admin ??= User::factory()->create([
            'role' => 'superadmin', 'nama' => 'Admin Satu', 'email' => 'admin1@unsia.my.id',
        ]);
    }

    protected function mahasiswa(string $nama = 'Budi Santoso'): User
    {
        return User::factory()->create([
            'role' => 'mahasiswa',
            'nama' => $nama,
            'nim' => '220000'.random_int(1000, 9999),
            'email' => null,
            'prodi_id' => Prodi::firstOrCreate(['nama_prodi' => 'Akuntansi'])->id,
            'tahun_ajar_id' => $this->periode->id,
        ]);
    }

    protected function data(array $ganti = []): array
    {
        return array_merge([
            'tahun_ajar_id' => $this->periode->id,
            'metode' => 'ewallet',
            'penyedia' => 'GoPay',
            'nomor' => '081200000001',
            'atas_nama' => 'Budi Santoso',
        ], $ganti);
    }

    // ---------- Pencocokan nama ----------

    public function test_nama_rekening_harus_sama_dengan_nama_mahasiswa(): void
    {
        $this->actingAs($this->mahasiswa('Budi Santoso'))
            ->post(route('cashback.store'), $this->data(['atas_nama' => 'Siti Aminah']))
            ->assertSessionHasErrors('atas_nama');

        $this->assertDatabaseCount('pengajuan_cashback', 0);
    }

    public function test_nama_yang_disingkat_juga_ditolak(): void
    {
        $this->actingAs($this->mahasiswa('Budi Santoso'))
            ->post(route('cashback.store'), $this->data(['atas_nama' => 'Budi S']))
            ->assertSessionHasErrors('atas_nama');
    }

    /**
     * Huruf besar-kecil dan spasi ganda hanya soal cara menulis, bukan nama
     * yang berbeda — keduanya tidak boleh menjegal mahasiswa yang benar.
     */
    public function test_beda_huruf_besar_dan_spasi_tetap_diterima(): void
    {
        foreach (['budi santoso', 'BUDI SANTOSO', '  Budi   Santoso  '] as $tulisan) {
            $user = $this->mahasiswa('Budi Santoso');

            $this->actingAs($user)
                ->post(route('cashback.store'), $this->data(['atas_nama' => $tulisan]))
                ->assertSessionHasNoErrors();
        }

        $this->assertDatabaseCount('pengajuan_cashback', 3);
    }

    public function test_pencocokan_nama_sebagai_fungsi(): void
    {
        $this->assertTrue(PengajuanCashback::namaCocok('Budi Santoso', 'budi  santoso'));
        $this->assertFalse(PengajuanCashback::namaCocok('Budi S', 'Budi Santoso'));
        $this->assertFalse(PengajuanCashback::namaCocok('', 'Budi Santoso'));
        $this->assertFalse(PengajuanCashback::namaCocok('   ', '   '));
    }

    // ---------- Log ----------

    public function test_pengajuan_tercatat_di_log(): void
    {
        $user = $this->mahasiswa();

        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $log = LogCashback::firstOrFail();

        $this->assertSame('diajukan', $log->aksi);
        $this->assertSame($user->id, $log->oleh_user_id);
        $this->assertNull($log->status_lama);
        $this->assertSame('menunggu', $log->status_baru);
    }

    public function test_verifikasi_tolak_dan_bayar_tercatat_berurutan(): void
    {
        Storage::fake('local');

        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $pengajuan = PengajuanCashback::firstOrFail();

        $this->actingAs($this->admin())
            ->patch(route('admin.cashback.verifikasi', $pengajuan), ['catatan_admin' => 'rekening cocok']);

        $this->actingAs($this->admin())
            ->post(route('admin.cashback.bayar', $pengajuan), [
                'bukti' => UploadedFile::fake()->image('transfer.jpg'),
            ]);

        $aksi = $pengajuan->log()->pluck('aksi')->all();

        $this->assertSame(['diajukan', 'diverifikasi', 'dibayar'], $aksi);
    }

    public function test_penolakan_mencatat_alasannya(): void
    {
        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $pengajuan = PengajuanCashback::firstOrFail();

        $this->actingAs($this->admin())
            ->patch(route('admin.cashback.tolak', $pengajuan), [
                'catatan_admin' => 'Nama GoPay tidak cocok dengan nama mahasiswa.',
            ]);

        $log = $pengajuan->log()->where('aksi', 'ditolak')->firstOrFail();

        $this->assertSame('menunggu', $log->status_lama);
        $this->assertSame('ditolak', $log->status_baru);
        $this->assertStringContainsString('Nama GoPay tidak cocok', $log->catatan);
        $this->assertSame($this->admin()->id, $log->oleh_user_id);
    }

    public function test_alasan_penolakan_wajib_diisi(): void
    {
        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $pengajuan = PengajuanCashback::firstOrFail();

        $this->actingAs($this->admin())
            ->patch(route('admin.cashback.tolak', $pengajuan), ['catatan_admin' => ''])
            ->assertSessionHasErrors('catatan_admin');

        $this->assertSame('menunggu', $pengajuan->fresh()->status);
    }

    /**
     * Pembatalan dulu menghapus barisnya, yang membuat lognya ikut terhapus
     * lewat cascade — justru peristiwa yang ingin dicatat yang hilang.
     */
    public function test_pembatalan_menyimpan_riwayat_bukan_menghapusnya(): void
    {
        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $pengajuan = PengajuanCashback::firstOrFail();

        $this->actingAs($user)->delete(route('cashback.batal', $pengajuan));

        $this->assertDatabaseCount('pengajuan_cashback', 1);
        $this->assertSame('dibatalkan', $pengajuan->fresh()->status);
        $this->assertSame(['diajukan', 'dibatalkan'], $pengajuan->log()->pluck('aksi')->all());
    }

    public function test_pembatalan_tidak_mengunci_pengajuan_berikutnya(): void
    {
        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $this->actingAs($user)->delete(route('cashback.batal', PengajuanCashback::firstOrFail()));

        $this->actingAs($user)
            ->post(route('cashback.store'), $this->data())
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('pengajuan_cashback', 2);
    }

    public function test_log_ikut_terhapus_saat_pengajuannya_dihapus(): void
    {
        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $this->assertDatabaseCount('log_cashback', 1);

        PengajuanCashback::firstOrFail()->delete();

        $this->assertDatabaseCount('log_cashback', 0);
    }

    /** Log tidak boleh punya updated_at: barisnya tidak pernah diubah. */
    public function test_log_bersifat_tambah_saja(): void
    {
        $user = $this->mahasiswa();
        $this->actingAs($user)->post(route('cashback.store'), $this->data());

        $log = LogCashback::firstOrFail();

        $this->assertNotNull($log->created_at);
        $this->assertNull(LogCashback::UPDATED_AT);
    }
}
