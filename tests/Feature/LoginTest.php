<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Pembatasan percobaan masuk.
 *
 * Sebelumnya tidak ada batas sama sekali: siapa pun bisa mencoba password
 * tanpa henti, sementara email pengelola mudah ditebak.
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    private const PESAN_SALAH = 'Email/NIM atau password salah.';

    protected function setUp(): void
    {
        parent::setUp();

        // Pembatas memakai cache yang sama antartes.
        RateLimiter::clear('login:'.sha1('admin@unsia.my.id|127.0.0.1'));
    }

    protected function admin(): User
    {
        return User::factory()->create([
            'role' => 'superadmin',
            'email' => 'admin@unsia.my.id',
            'password' => Hash::make('rahasia-sekali'),
        ]);
    }

    protected function coba(string $password): \Illuminate\Testing\TestResponse
    {
        return $this->post(route('login'), [
            'login' => 'admin@unsia.my.id',
            'password' => $password,
        ]);
    }

    public function test_password_benar_bisa_masuk(): void
    {
        $this->admin();

        $this->coba('rahasia-sekali')->assertRedirect();

        $this->assertAuthenticated();
    }

    public function test_percobaan_ditahan_setelah_lima_kali_gagal(): void
    {
        $this->admin();

        for ($i = 1; $i <= 5; $i++) {
            $this->coba('salah')->assertInvalid(['login' => self::PESAN_SALAH]);
            $this->assertGuest();
        }

        $this->coba('salah')->assertInvalid(['login' => 'Terlalu banyak percobaan masuk.']);
    }

    /**
     * Yang penting: setelah tertahan, password yang BENAR pun ikut ditolak.
     * Tanpa itu, penyerang hanya perlu terus mencoba sampai kena.
     */
    public function test_password_benar_tetap_ditolak_selama_tertahan(): void
    {
        $this->admin();

        for ($i = 1; $i <= 5; $i++) {
            $this->coba('salah');
        }

        $this->coba('rahasia-sekali');

        $this->assertGuest();
    }

    public function test_hitungan_dinolkan_setelah_berhasil_masuk(): void
    {
        $this->admin();

        // Beberapa kali salah, lalu benar.
        $this->coba('salah');
        $this->coba('salah');
        $this->coba('rahasia-sekali')->assertRedirect();

        $this->post(route('logout'));

        // Jatah percobaan harus utuh lagi, bukan tersisa tiga.
        for ($i = 1; $i <= 5; $i++) {
            $this->coba('salah')->assertInvalid(['login' => self::PESAN_SALAH]);
        }

        $this->coba('salah')->assertInvalid(['login' => 'Terlalu banyak percobaan masuk.']);
    }

    /**
     * Dikunci per identitas DAN alamat IP. Kalau hanya per IP, satu jaringan
     * kampus bisa saling menjegal.
     */
    public function test_akun_lain_tidak_ikut_tertahan(): void
    {
        $this->admin();

        User::factory()->create([
            'role' => 'mahasiswa',
            'nim' => '2201234567',
            'email' => null,
            'password' => Hash::make('rahasia-mahasiswa'),
        ]);

        for ($i = 1; $i <= 6; $i++) {
            $this->coba('salah');
        }

        $this->post(route('login'), [
            'login' => '2201234567',
            'password' => 'rahasia-mahasiswa',
        ])->assertRedirect();

        $this->assertAuthenticated();
    }

    /** Pesan galat tidak boleh membocorkan akun mana yang ada. */
    public function test_pesan_galat_tidak_membedakan_akun_ada_atau_tidak(): void
    {
        $this->admin();

        // Pesannya harus persis sama, bukan hanya mirip: selisih kata sedikit
        // pun sudah cukup untuk memetakan email mana yang terdaftar.
        $pesan = ['login' => self::PESAN_SALAH];

        $this->coba('salah')->assertSessionHasErrors($pesan);

        $this->post(route('login'), [
            'login' => 'entahsiapa@contoh.id',
            'password' => 'apa saja',
        ])->assertSessionHasErrors($pesan);
    }
}
