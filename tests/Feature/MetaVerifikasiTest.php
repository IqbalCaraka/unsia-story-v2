<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Tag verifikasi domain Google dan Meta mudah hilang tanpa sadar saat layout
 * diubah, dan hilangnya tidak terlihat di tampilan — yang rusak adalah
 * atribusi iklan, biasanya baru ketahuan jauh belakangan.
 */
class MetaVerifikasiTest extends TestCase
{
    public function test_tag_verifikasi_ada_di_beranda(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('name="google-site-verification"', false)
            ->assertSee('name="facebook-domain-verification"', false)
            ->assertSee('cqok0eefx3gthlfvu65wu69hn9yhtb', false);
    }

    /**
     * Meta dan Google hanya membaca tag yang ada di dalam <head> pada HTML
     * yang dikirim server. Tag yang terlempar ke <body>, atau yang disisipkan
     * lewat JavaScript, tidak akan ditemukan.
     */
    public function test_tag_verifikasi_berada_di_dalam_head(): void
    {
        $html = $this->get('/')->assertStatus(200)->getContent();

        $posisiTag = strpos($html, 'facebook-domain-verification');
        $posisiTutupHead = strpos($html, '</head>');

        $this->assertNotFalse($posisiTag, 'Tag verifikasi Meta tidak ada di beranda.');
        $this->assertNotFalse($posisiTutupHead, 'Beranda tidak punya </head>.');

        $this->assertLessThan(
            $posisiTutupHead,
            $posisiTag,
            'Tag verifikasi Meta berada di luar <head>, sehingga tidak akan terbaca.'
        );

        $this->assertDoesNotMatchRegularExpression(
            '#<script[^>]*>(?:(?!</script>).)*facebook-domain-verification#s',
            $html,
            'Tag verifikasi Meta tidak boleh berada di dalam <script>.'
        );
    }
}
