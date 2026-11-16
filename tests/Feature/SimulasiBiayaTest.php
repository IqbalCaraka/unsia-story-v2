<?php

namespace Tests\Feature;

use App\Support\Referral as R;
use Tests\TestCase;

class SimulasiBiayaTest extends TestCase
{
    public function test_simulasi_tampil_di_beranda(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('id="simulasi-biaya"', false)
            ->assertSee('Tanpa Kode Referal')
            ->assertSee('Dengan Kode Referal')
            ->assertSee('id="simKode"', false)
            ->assertSee('Hitung Sendiri Hematnya');
    }

    public function test_dua_skema_pembayaran_tersedia(): void
    {
        $this->get('/')
            ->assertSee('data-sim-panel="lunas"', false)
            ->assertSee('data-sim-panel="cicilan"', false)
            ->assertSee('Bayar Lunas')
            ->assertSee('Cicil '.R::jumlahCicilan().'x');
    }

    /**
     * Panel "dengan kode" harus terkunci sebelum kode diisi, dan versi
     * terbukanya tetap dirender di server — JavaScript hanya menampilkannya.
     */
    public function test_panel_dengan_kode_terkunci_sebelum_kode_diisi(): void
    {
        $html = $this->get('/')->assertStatus(200)->getContent();

        $this->assertStringContainsString('data-sim-terkunci', $html);
        $this->assertStringContainsString('data-sim-terbuka hidden', $html);
        $this->assertStringContainsString('Masukkan kode referal di atas', $html);
    }

    public function test_hitungan_lunas_benar(): void
    {
        $this->assertSame(3_000_000, R::ukt());
        $this->assertSame(2_500_000, R::setelahPotongan());
        $this->assertSame(2_400_000, R::biayaBersih());
        $this->assertSame(600_000, R::totalManfaat());

        $this->get('/')
            ->assertSee(R::rupiah(R::ukt()))
            ->assertSee(R::rupiah(R::setelahPotongan()))
            ->assertSee(R::rupiah(R::biayaBersih()))
            ->assertSee(R::rupiah(R::totalManfaat()));
    }

    /**
     * Potongan dan cashback tidak dibagi rata: keduanya baru dikurangkan pada
     * cicilan ke-3, sehingga dua cicilan pertama tetap penuh.
     */
    public function test_potongan_hanya_pada_cicilan_terakhir(): void
    {
        $rincian = R::rincianCicilan();

        $this->assertCount(3, $rincian);

        $this->assertSame(1_000_000, $rincian[0]['dengan_kode'], 'Cicilan 1 harus penuh');
        $this->assertSame(1_000_000, $rincian[1]['dengan_kode'], 'Cicilan 2 harus penuh');
        $this->assertSame(400_000, $rincian[2]['dengan_kode'], 'Cicilan 3 = 1jt - 500rb - 100rb');

        $this->assertSame(0, $rincian[0]['potongan']);
        $this->assertSame(0, $rincian[1]['potongan']);
        $this->assertSame(500_000, $rincian[2]['potongan']);
        $this->assertSame(100_000, $rincian[2]['cashback']);
    }

    /**
     * Dua skema harus bermuara ke angka yang sama. Kalau tidak, salah satu
     * panel menjanjikan hal yang berbeda dari panel sebelahnya.
     */
    public function test_total_cicilan_sama_dengan_bayar_lunas(): void
    {
        $rincian = R::rincianCicilan();

        $this->assertSame(
            R::ukt(),
            array_sum(array_column($rincian, 'tanpa_kode')),
            'Total cicilan tanpa kode harus sama dengan UKT'
        );

        $this->assertSame(
            R::biayaBersih(),
            array_sum(array_column($rincian, 'dengan_kode')),
            'Total cicilan dengan kode harus sama dengan biaya bersih'
        );
    }

    /** Pembagian cicilan tidak boleh menghilangkan rupiah karena pembulatan. */
    public function test_pembagian_cicilan_tidak_kehilangan_rupiah(): void
    {
        foreach ([3_000_000, 3_000_001, 2_999_999, 1_000_000] as $ukt) {
            config(['referral.ukt' => $ukt]);

            $this->assertSame(
                $ukt,
                array_sum(array_column(R::rincianCicilan(), 'tanpa_kode')),
                "UKT $ukt tidak terbagi utuh"
            );
        }
    }

    /**
     * Angka yang sama masih ditulis sebagai prosa di beberapa halaman. Tes ini
     * mengikat prosa itu ke config/referral.php, supaya tidak bisa menyimpang
     * diam-diam — persis yang pernah terjadi pada "Rp150rb" di beranda.
     */
    public function test_prosa_di_halaman_sesuai_dengan_config(): void
    {
        foreach (['/', '/tentang-kode-referral'] as $url) {
            $this->get($url)
                ->assertStatus(200)
                ->assertSee(R::rupiah(R::potongan()))
                ->assertSee(R::rupiah(R::cashback()))
                ->assertSee(R::rupiah(R::totalManfaat()));
        }
    }

    public function test_kode_yang_diminta_sama_dengan_kode_yang_diiklankan(): void
    {
        $this->assertSame('unsia.my.id', R::kode());

        $this->get('/')->assertSee(R::kode());
    }

    /** Skrip simulasi tidak boleh menghitung sendiri, hanya menampilkan. */
    public function test_javascript_tidak_mengandung_nominal(): void
    {
        $html = $this->get('/')->assertStatus(200)->getContent();

        preg_match_all('#<script>(.*?)</script>#s', $html, $skrip);

        foreach ($skrip[1] as $isi) {
            if (! str_contains($isi, 'simulasi-biaya')) {
                continue;
            }

            foreach ([R::ukt(), R::potongan(), R::cashback(), R::biayaBersih()] as $nominal) {
                $this->assertStringNotContainsString(
                    (string) $nominal,
                    $isi,
                    'Skrip simulasi memuat nominal; angka harus datang dari server saja.'
                );
            }

            return;
        }

        $this->fail('Skrip simulasi tidak ditemukan di beranda.');
    }
}
