<?php

namespace Tests\Feature;

use Tests\TestCase;

class KontakTest extends TestCase
{
    /**
     * Nomor CS tersimpan dua kali: satu untuk dibaca pengunjung dan satu
     * untuk tautan wa.me. Keduanya pernah tidak sinkron sebesar satu digit
     * tanpa terdeteksi, sehingga setiap tombol WhatsApp di situs mengarah
     * ke nomor yang bukan milik kami. Tes ini mengunci keduanya.
     */
    public function test_nomor_cs_yang_tampil_sama_dengan_nomor_di_tautan_wa(): void
    {
        $tampil = config('kontak.cs.telepon');
        $wa = config('kontak.cs.wa');

        // "+62 813-333-1686" -> "628133331686"
        $tampilDinormalkan = preg_replace('/[^0-9]/', '', $tampil);

        $this->assertSame(
            $tampilDinormalkan,
            $wa,
            "Nomor CS tidak sinkron: yang tampil \"{$tampil}\" menjadi \"{$tampilDinormalkan}\", "
            ."sedangkan tautan wa.me memakai \"{$wa}\". Perbaiki config/kontak.php."
        );
    }

    public function test_tautan_wa_hanya_berisi_angka(): void
    {
        // wa.me menolak "+", spasi, dan tanda hubung.
        $this->assertMatchesRegularExpression('/^[0-9]+$/', config('kontak.cs.wa'));
    }

    public function test_email_bisnis_valid(): void
    {
        $this->assertNotFalse(filter_var(config('kontak.bisnis.email'), FILTER_VALIDATE_EMAIL));
    }

    /**
     * Mencegah data kontak kembali ditulis langsung di Blade seperti dulu.
     */
    public function test_tidak_ada_data_kontak_yang_hardcoded_di_blade(): void
    {
        $nilai = [
            config('kontak.cs.wa'),
            config('kontak.bisnis.email'),
            config('kontak.alamat.satu_baris'),
        ];

        $berkas = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(resource_path('views'))
        );

        $pelanggar = [];

        foreach ($berkas as $file) {
            if ($file->isDir() || ! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $isi = file_get_contents($file->getPathname());

            foreach ($nilai as $v) {
                if (str_contains($isi, $v)) {
                    $pelanggar[] = $file->getFilename().' memuat "'.$v.'"';
                }
            }
        }

        $this->assertSame(
            [],
            $pelanggar,
            "Data kontak harus diambil lewat config('kontak.*'), bukan ditulis langsung:\n"
            .implode("\n", $pelanggar)
        );
    }

    public function test_halaman_tentang_menampilkan_kedua_kontak(): void
    {
        $this->get('/about')
            ->assertStatus(200)
            ->assertSee(config('kontak.bisnis.nama'))
            ->assertSee(config('kontak.bisnis.email'))
            ->assertSee(config('kontak.bisnis.telepon'))
            ->assertSee(config('kontak.cs.nama'))
            ->assertSee(config('kontak.cs.telepon'))
            ->assertSee('wa.me/'.config('kontak.cs.wa'));
    }

    public function test_data_kontak_lama_sudah_tidak_muncul(): void
    {
        $lama = [
            'unsia.story@gmail.com',
            'Monumen Pancasila',
            'Lubang Buaya',
            '13810',
            '0813-3333-1686',
        ];

        foreach (['/', '/about', '/faq', '/bantuan-pendanaan'] as $url) {
            $response = $this->get($url)->assertStatus(200);

            foreach ($lama as $jejak) {
                $response->assertDontSee($jejak);
            }
        }
    }
}
