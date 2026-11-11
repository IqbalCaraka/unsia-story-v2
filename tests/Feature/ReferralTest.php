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
            ->assertSee('Cashback Rp150.000')
            ->assertSee('Webinar Rutin')
            ->assertSee('Pendampingan 1 Semester');
    }

    public function test_menu_tentang_punya_dua_pilihan(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Tentang unsia.my.id')
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
        $klaimLama = [
            'cashback Rp150.000 di semester kedua',
            'Cashback semester 2',
            'Semester kedua: cashback',
            'cashback Rp150rb semester kedua',
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
        $potongan = 500_000;
        $cashback = 150_000;

        $bersih = $ukt - $potongan - $cashback;

        $this->assertSame(2_350_000, $bersih);

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
