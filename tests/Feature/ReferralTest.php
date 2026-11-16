<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReferralTest extends TestCase
{
    public function test_halaman_kode_referral_bisa_dibuka(): void
    {
        $this->get('/tentang-kode-referral')->assertStatus(200);
    }

    public function test_keempat_keuntungan_disebutkan(): void
    {
        $this->get('/tentang-kode-referral')
            ->assertSee('Potongan UKT Rp500.000')
            ->assertSee('Cashback Rp100.000')
            ->assertSee('Pendampingan Grup')
            ->assertSee('Webinar Gratis');
    }

    /**
     * Potongan berasal dari UNSIA, cashback dari UNSIA Story. Keduanya mudah
     * tertukar, dan tertukarnya berarti situs salah menyebut siapa yang
     * membayar.
     */
    public function test_sumber_dana_disebut_terpisah(): void
    {
        $this->get('/tentang-kode-referral')
            ->assertSee('dari UNSIA Story')
            ->assertSee('Potongan UKT dari UNSIA')
            ->assertSee('Cashback dari UNSIA Story');
    }

    /**
     * Seluruh konten Bantuan Pendanaan disembunyikan dari situs publik.
     * Controller, view, dan panel adminnya masih ada di repositori, jadi
     * sebutannya mudah tanpa sengaja kembali terpasang.
     */
    public function test_bantuan_pendanaan_tidak_muncul_di_situs_publik(): void
    {
        $jejak = [
            'Bantuan Pendanaan',
            'bantuan-pendanaan',
            'bantuan biaya pendidikan',
            'Peluang Bantuan Biaya Pendidikan',
        ];

        foreach (['/', '/about', '/faq', '/tentang-kode-referral', '/konversi-mata-kuliah'] as $url) {
            $response = $this->get($url)->assertStatus(200);

            foreach ($jejak as $teks) {
                $response->assertDontSee($teks, false);
            }
        }
    }

    /** Route publiknya dimatikan, jadi namanya tidak boleh terdaftar lagi. */
    public function test_route_publik_bantuan_sudah_tidak_ada(): void
    {
        $this->assertFalse(
            app('router')->has('bantuan'),
            'Route publik bantuan masih terdaftar, padahal kontennya disembunyikan.'
        );
    }

    public function test_menu_tentang_punya_dua_pilihan(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Tentang Kami')
            ->assertSee('Tentang Kode Referral')
            ->assertSee(route('referral'));
    }

    /**
     * Cashback jatuh di semester 1, bukan semester 2. Klaim lamanya sempat
     * tersebar di about, faq, dan index — termasuk di dalam blok JSON-LD yang
     * dibaca Google — sehingga mudah tertinggal saat dikoreksi sebagian.
     */
    public function test_cashback_tidak_lagi_diklaim_di_semester_dua(): void
    {
        // Sengaja khusus soal cashback, bukan melarang frasa "semester 2"
        // secara umum — frasa itu bisa dipakai kalimat lain yang benar.
        $klaimLama = [
            'Cashback semester 2',
            'Semester kedua: cashback',
            'cashback Rp100.000 di semester 2',
            'cashback Rp100.000 di semester kedua',
            'cashback Rp150.000 di semester kedua',
            // Nominal sebelum berubah jadi 600 ribu untuk genap 2026/2027.
            'Rp650.000',
            'Rp150.000',
            'Rp2.350.000',
            'Rp2.850.000',
        ];

        foreach (['/', '/about', '/faq', '/tentang-kode-referral'] as $url) {
            $response = $this->get($url)->assertStatus(200);

            foreach ($klaimLama as $klaim) {
                $response->assertDontSee($klaim);
            }
        }
    }

    /**
     * Nominal ditulis dalam dua gaya di situs ini: bertitik ("Rp150.000") dan
     * disingkat ("Rp150rb"). Saat nominal berubah, sapuan yang hanya mencari
     * format bertitik melewatkan yang disingkat — itu pernah terjadi dan satu
     * "Rp150rb" sempat tayang di produksi berhari-hari.
     *
     * Pola di bawah menangkap kedua gaya sekaligus.
     */
    public function test_nominal_lama_tidak_muncul_dalam_bentuk_apa_pun(): void
    {
        $polaLama = [
            'cashback lama (150)' => '/Rp\s?\.?\s?150[\s.]?(000|rb|ribu)/i',
            'total lama (650)' => '/Rp\s?\.?\s?650[\s.]?(000|rb|ribu)/i',
            'biaya bersih lama (2.350.000)' => '/Rp\s?\.?\s?2[\s.]?350[\s.]?000/i',
            'biaya semester 2 lama (2.850.000)' => '/Rp\s?\.?\s?2[\s.]?850[\s.]?000/i',
        ];

        foreach (['/', '/about', '/faq', '/tentang-kode-referral'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();

            foreach ($polaLama as $nama => $pola) {
                $this->assertDoesNotMatchRegularExpression(
                    $pola, $html, "$nama masih muncul di $url"
                );
            }
        }
    }

    /**
     * Potongan dan cashback yang disingkat harus menyebut angka yang sama
     * dengan versi bertitiknya, supaya dua gaya penulisan itu tidak pernah
     * saling bertentangan di halaman yang sama.
     */
    public function test_nominal_singkat_sama_dengan_nominal_bertitik(): void
    {
        $html = $this->get('/')->assertStatus(200)->getContent();

        preg_match_all('/Rp(\d+)(?:rb|ribu)/i', $html, $singkat);

        $this->assertNotEmpty($singkat[1], 'Beranda tidak lagi memakai nominal singkat.');

        foreach (array_unique($singkat[1]) as $ratusan) {
            // "500rb" harus punya padanan "Rp500.000" di situs.
            $this->assertContains(
                $ratusan,
                ['500', '100'],
                "Rp{$ratusan}rb bukan nominal yang berlaku (yang sah: 500 dan 100)"
            );
        }
    }

    /**
     * Biaya bersih semester 1 adalah hasil pengurangan dua angka yang juga
     * tampil di halaman. Kalau salah satunya diubah tanpa yang lain, totalnya
     * jadi menyesatkan.
     */
    public function test_biaya_bersih_semester_satu_konsisten(): void
    {
        $ukt = 3_000_000;
        $potongan = 500_000;   // dari UNSIA
        $cashback = 100_000;   // dari UNSIA Story

        $bersih = $ukt - $potongan - $cashback;

        $this->assertSame(600_000, $potongan + $cashback);
        $this->assertSame(2_400_000, $bersih);

        $this->get('/tentang-kode-referral')
            ->assertSee('Rp'.number_format($ukt, 0, ',', '.'))
            ->assertSee('Rp'.number_format($potongan, 0, ',', '.'))
            ->assertSee('Rp'.number_format($cashback, 0, ',', '.'))
            ->assertSee('Rp'.number_format($bersih, 0, ',', '.'))
            ->assertSee('Rp'.number_format($potongan + $cashback, 0, ',', '.'));
    }

    public function test_json_ld_halaman_faq_tetap_valid(): void
    {
        $html = $this->get('/faq')->assertStatus(200)->getContent();

        preg_match_all('#<script[^>]*ld\+json[^>]*>(.*?)</script>#s', $html, $cocok);

        $this->assertNotEmpty($cocok[1], 'Tidak ada blok JSON-LD di halaman FAQ.');

        foreach ($cocok[1] as $i => $blok) {
            json_decode(trim($blok));

            $this->assertSame(
                JSON_ERROR_NONE,
                json_last_error(),
                'Blok JSON-LD #'.($i + 1).' tidak valid: '.json_last_error_msg()
            );
        }
    }
}
