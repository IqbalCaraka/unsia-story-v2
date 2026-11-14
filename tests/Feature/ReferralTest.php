<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReferralTest extends TestCase
{
    public function test_halaman_kode_referral_bisa_dibuka(): void
    {
        $this->get('/tentang-kode-referral')->assertStatus(200);
    }

    public function test_kelima_keuntungan_disebutkan(): void
    {
        $this->get('/tentang-kode-referral')
            ->assertSee('Potongan UKT Rp500.000')
            ->assertSee('Cashback Rp100.000')
            ->assertSee('Pendampingan Grup')
            ->assertSee('Webinar Gratis')
            ->assertSee('Peluang Bantuan Biaya Pendidikan');
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
     * Peluang bantuan biaya pendidikan itu program yang sudah punya halaman
     * sendiri. Halaman referral harus menautkannya, bukan menjelaskan ulang
     * dengan kalimat yang bisa menyimpang dari halaman aslinya.
     */
    public function test_peluang_bantuan_menaut_ke_halaman_programnya(): void
    {
        $this->get('/tentang-kode-referral')
            ->assertSee(route('bantuan'));
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
        // Sengaja khusus soal cashback. "Semester 2" sendiri BUKAN klaim
        // terlarang — seleksi bantuan biaya pendidikan memang berlangsung di
        // semester 2, jadi melarang frasanya secara umum akan menjegal
        // kalimat yang benar.
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
