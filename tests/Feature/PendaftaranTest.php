<?php

namespace Tests\Feature;

use App\Support\Pendaftaran;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PendaftaranTest extends TestCase
{
    public function test_beranda_menampilkan_info_pendaftaran(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Gelombang 1 Jalur Reguler')
            ->assertSee('13 - 26 November 2026')
            ->assertSee('Rp175.000')
            ->assertSee('pmb.unsia.ac.id')
            ->assertSee('unsia.my.id');
    }

    public function test_beranda_menyebut_kode_referal_dan_nilainya(): void
    {
        $this->get('/')
            ->assertSee('Rp600.000')
            ->assertSee('potongan UKT dari UNSIA')
            ->assertSee('cashback dari UNSIA Story')
            ->assertSee(route('referral'));
    }

    /**
     * Gelombang dan tanggalnya pernah ditulis terpisah di beranda dan FAQ,
     * sehingga FAQ tertinggal menyebut gelombang yang sudah lewat. Keduanya
     * kini membaca config/pendaftaran.php, jadi harus selalu sama.
     */
    public function test_beranda_dan_faq_menyebut_periode_yang_sama(): void
    {
        foreach (['/', '/faq'] as $url) {
            $this->get($url)
                ->assertStatus(200)
                ->assertSee(Pendaftaran::nama())
                ->assertSee(Pendaftaran::rentangTanggal())
                ->assertSee(Pendaftaran::biayaRupiah());
        }
    }

    public function test_gelombang_lama_tidak_muncul_lagi(): void
    {
        foreach (['/', '/faq'] as $url) {
            $this->get($url)
                ->assertDontSee('Gelombang 10')
                ->assertDontSee('September 2026');
        }
    }

    public function test_rentang_tanggal_tidak_mengulang_bulan_dalam_satu_bulan(): void
    {
        config(['pendaftaran.mulai' => '2026-11-13', 'pendaftaran.selesai' => '2026-11-26']);

        $this->assertSame('13 - 26 November 2026', Pendaftaran::rentangTanggal());
    }

    public function test_rentang_tanggal_menyebut_dua_bulan_saat_melewati_pergantian_bulan(): void
    {
        config(['pendaftaran.mulai' => '2026-11-28', 'pendaftaran.selesai' => '2026-12-03']);

        $this->assertSame('28 November - 3 Desember 2026', Pendaftaran::rentangTanggal());
    }

    public function test_rentang_tanggal_menyebut_dua_tahun_saat_melewati_tahun_baru(): void
    {
        config(['pendaftaran.mulai' => '2026-12-28', 'pendaftaran.selesai' => '2027-01-05']);

        $this->assertSame('28 Desember 2026 - 5 Januari 2027', Pendaftaran::rentangTanggal());
    }

    /**
     * Status dihitung dari tanggal, bukan ditulis tangan, supaya banner tidak
     * terus mengaku "dibuka" setelah periodenya lewat.
     */
    public function test_status_mengikuti_tanggal(): void
    {
        config(['pendaftaran.mulai' => '2026-11-13', 'pendaftaran.selesai' => '2026-11-26']);

        $kasus = [
            '2026-11-12 23:59' => 'Segera Dibuka',
            '2026-11-13 00:01' => 'Pendaftaran Dibuka',
            '2026-11-20 12:00' => 'Pendaftaran Dibuka',
            // Hari terakhir harus masih terhitung buka sampai tengah malam.
            '2026-11-26 23:59' => 'Pendaftaran Dibuka',
            '2026-11-27 00:01' => 'Pendaftaran Ditutup',
        ];

        foreach ($kasus as $waktu => $harapan) {
            Carbon::setTestNow(Carbon::parse($waktu, Pendaftaran::ZONA));

            $this->assertSame($harapan, Pendaftaran::statusLabel(), "Pada $waktu");
        }

        Carbon::setTestNow();
    }

    public function test_banner_tidak_mengaku_dibuka_setelah_periode_lewat(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-12-25', Pendaftaran::ZONA));

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Pendaftaran Ditutup')
            ->assertDontSee('Pendaftaran Dibuka');

        Carbon::setTestNow();
    }
}
