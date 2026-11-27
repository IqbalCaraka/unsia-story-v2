<?php

namespace Tests\Feature;

use App\Mail\PasswordAkunMahasiswa;
use App\Models\User;
use App\Support\PasswordAwal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class BuatAkunTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        // Pembatas laju memakai cache yang sama antartes; dibersihkan supaya
        // satu tes tidak menjegal tes berikutnya.
        RateLimiter::clear('buat-akun:ip:127.0.0.1');
    }

    protected function mahasiswa(array $ganti = []): User
    {
        return User::factory()->create(array_merge([
            'role' => 'mahasiswa',
            'nama' => 'Budi Santoso',
            'nim' => '2201234567',
            'email' => 'budi@contoh.id',
            'terakhir_login_pada' => null,
        ], $ganti));
    }

    public function test_halaman_buat_akun_bisa_dibuka(): void
    {
        $this->get(route('buat-akun'))
            ->assertStatus(200)
            ->assertSee('Buat Akun')
            ->assertSee('name="email"', false);
    }

    public function test_password_dikirim_ke_email_mahasiswa(): void
    {
        $user = $this->mahasiswa();

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id'])
            ->assertSessionHas('status');

        Mail::assertSent(PasswordAkunMahasiswa::class, fn ($mail) => $mail->hasTo('budi@contoh.id'));
    }

    public function test_password_yang_dikirim_sama_dengan_yang_tersimpan(): void
    {
        $user = $this->mahasiswa();

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id']);

        Mail::assertSent(PasswordAkunMahasiswa::class, function ($mail) use ($user) {
            // Password di email harus benar-benar bisa dipakai masuk.
            return Hash::check($mail->password, $user->fresh()->password);
        });
    }

    public function test_password_panjangnya_16_karakter(): void
    {
        $this->mahasiswa();

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id']);

        Mail::assertSent(PasswordAkunMahasiswa::class,
            fn ($mail) => strlen($mail->password) === 16);
    }

    /**
     * Huruf yang mudah tertukar saat dibaca dari email tidak boleh muncul,
     * karena mahasiswa mengetiknya ulang secara manual.
     */
    public function test_password_tidak_memuat_huruf_yang_membingungkan(): void
    {
        for ($i = 0; $i < 200; $i++) {
            $this->assertDoesNotMatchRegularExpression('/[0O1lI]/', PasswordAwal::buat());
        }
    }

    public function test_password_selalu_berbeda(): void
    {
        $kumpulan = [];

        for ($i = 0; $i < 50; $i++) {
            $kumpulan[] = PasswordAwal::buat();
        }

        $this->assertCount(50, array_unique($kumpulan));
    }

    public function test_email_bisa_ditulis_dengan_huruf_besar(): void
    {
        $this->mahasiswa();

        $this->post(route('buat-akun.kirim'), ['email' => 'BUDI@CONTOH.ID'])
            ->assertSessionHas('status');

        Mail::assertSent(PasswordAkunMahasiswa::class);
    }

    // ---------- Yang tidak boleh terjadi ----------

    /**
     * Jawaban untuk email tak dikenal harus sama persis dengan yang terdaftar,
     * supaya orang luar tidak bisa memetakan email mana yang ada di sistem.
     */
    public function test_email_tak_dikenal_dijawab_sama_dan_tidak_mengirim_apa_pun(): void
    {
        $this->mahasiswa();

        // Dibandingkan dengan teks yang pasti, bukan membandingkan dua respons
        // satu sama lain: keduanya berbagi satu sesi di dalam pengujian,
        // sehingga perbandingan seperti itu selalu benar dengan sendirinya.
        $diharapkan = fn ($response) => $response->assertSessionHas(
            'status',
            fn ($pesan) => str_contains($pesan, 'Jika email tersebut terdaftar')
        );

        $diharapkan($this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id']));
        $diharapkan($this->post(route('buat-akun.kirim'), ['email' => 'entahsiapa@contoh.id']));

        // Hanya yang terdaftar yang benar-benar dikirimi email.
        Mail::assertSentCount(1);
    }

    public function test_akun_yang_pernah_login_ditolak(): void
    {
        $this->mahasiswa(['terakhir_login_pada' => now()->subDay()]);

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id'])
            ->assertSessionHas('status');

        Mail::assertNothingSent();
    }

    public function test_password_akun_yang_pernah_login_tidak_diubah(): void
    {
        $user = $this->mahasiswa(['terakhir_login_pada' => now()->subDay()]);
        $passwordLama = $user->password;

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id']);

        $this->assertSame($passwordLama, $user->fresh()->password);
    }

    public function test_role_selain_mahasiswa_ditolak(): void
    {
        foreach (['admin', 'superadmin', 'downline'] as $i => $role) {
            User::factory()->create([
                'role' => $role,
                'email' => "orang$i@contoh.id",
                'terakhir_login_pada' => null,
            ]);

            $this->post(route('buat-akun.kirim'), ['email' => "orang$i@contoh.id"])
                ->assertSessionHas('status');
        }

        Mail::assertNothingSent();
    }

    public function test_email_wajib_diisi_dan_berformat_email(): void
    {
        $this->post(route('buat-akun.kirim'), ['email' => ''])
            ->assertSessionHasErrors('email');

        $this->post(route('buat-akun.kirim'), ['email' => 'bukan-email'])
            ->assertSessionHasErrors('email');

        Mail::assertNothingSent();
    }

    /**
     * Tanpa pembatas laju, siapa pun yang tahu email seorang mahasiswa bisa
     * membanjiri kotak masuknya.
     */
    public function test_permintaan_berulang_untuk_email_sama_ditahan(): void
    {
        $this->mahasiswa();

        for ($i = 0; $i < 3; $i++) {
            $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id'])
                ->assertSessionHasNoErrors();
        }

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id'])
            ->assertSessionHasErrors('email');

        Mail::assertSentCount(3);
    }

    /**
     * Gangguan SMTP dulu menjadi 500 tanpa penjelasan apa pun.
     */
    public function test_gangguan_email_tidak_menjadi_error_500(): void
    {
        $this->mahasiswa();

        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP tumbang'));

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id'])
            ->assertStatus(302)
            ->assertSessionHasErrors('email');
    }

    /**
     * Inti perbaikannya: password hanya boleh berganti kalau emailnya benar-
     * benar terkirim. Urutan sebaliknya membuat akun mahasiswa tidak bisa
     * dipakai masuk begitu pengiriman gagal — passwordnya sudah diganti
     * menjadi nilai acak yang tidak diketahui siapa pun.
     */
    public function test_password_tidak_berganti_saat_pengiriman_gagal(): void
    {
        $user = $this->mahasiswa();
        $user->forceFill(['password' => Hash::make('passwordlama')])->save();

        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP tumbang'));

        $this->post(route('buat-akun.kirim'), ['email' => 'budi@contoh.id']);

        $this->assertTrue(
            Hash::check('passwordlama', $user->fresh()->password),
            'Password berubah padahal emailnya gagal dikirim'
        );
    }

    public function test_halaman_login_menautkan_ke_buat_akun(): void
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSee(route('buat-akun'));
    }

    public function test_login_mencatat_waktu_masuk(): void
    {
        $user = $this->mahasiswa();
        $user->forceFill(['password' => Hash::make('rahasia123')])->save();

        $this->assertNull($user->terakhir_login_pada);

        $this->post(route('login'), ['login' => '2201234567', 'password' => 'rahasia123']);

        $this->assertNotNull($user->fresh()->terakhir_login_pada);
    }
}
