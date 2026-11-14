<?php

namespace Tests\Feature;

use App\Models\Downline;
use App\Models\DownlineSocialMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DownlineSocialMediaTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $super = null;

    protected function superadmin(): User
    {
        return $this->super ??= User::factory()->create([
            'role' => 'superadmin',
            'nama' => 'Super',
            'email' => 'super@unsia.my.id',
        ]);
    }

    protected function simpanDownline(array $sosmed, array $ganti = []): User
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), array_merge([
                'nama' => 'Mitra Satu',
                'email' => 'mitra1@contoh.id',
                'role' => 'downline',
                'status_downline' => 'aktif',
                'password' => 'rahasia123',
                'password_confirmation' => 'rahasia123',
                'social_media' => $sosmed,
            ], $ganti))
            ->assertSessionHasNoErrors();

        return User::where('email', 'mitra1@contoh.id')->firstOrFail();
    }

    public function test_sosial_media_tersimpan_untuk_downline(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
            ['platform' => 'tiktok', 'akun' => 'unsia.my.id'],
            ['platform' => 'blog', 'akun' => 'https://blogsaya.id'],
        ]);

        $this->assertCount(3, $user->downline->socialMedia);

        $this->assertDatabaseHas('downline_social_media', [
            'downline_id' => $user->downline->id,
            'platform' => 'instagram',
            'akun' => 'unsia.my.id',
        ]);
    }

    public function test_keenam_platform_diterima(): void
    {
        $baris = [];
        foreach (DownlineSocialMedia::platformYangSah() as $i => $platform) {
            $baris[] = [
                'platform' => $platform,
                'akun' => $platform === 'blog' ? 'https://blogsaya.id' : "akun$i",
            ];
        }

        $user = $this->simpanDownline($baris);

        $this->assertCount(6, $user->downline->socialMedia);
        $this->assertEqualsCanonicalizing(
            DownlineSocialMedia::platformYangSah(),
            $user->downline->socialMedia->pluck('platform')->all()
        );
    }

    public function test_platform_di_luar_daftar_ditolak(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), [
                'nama' => 'Mitra Satu',
                'email' => 'mitra1@contoh.id',
                'role' => 'downline',
                'status_downline' => 'aktif',
                'password' => 'rahasia123',
                'password_confirmation' => 'rahasia123',
                'social_media' => [['platform' => 'linkedin', 'akun' => 'budi']],
            ])
            ->assertSessionHasErrors('social_media.0.platform');
    }

    /**
     * Admin sering menempel tautan utuh atau menulis pakai "@". Tanpa
     * perapian, satu akun yang sama bisa tercatat dalam beberapa bentuk.
     */
    public function test_tautan_dan_at_dirapikan_jadi_username(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'https://www.instagram.com/unsia.my.id/'],
            ['platform' => 'x', 'akun' => '@unsia'],
            ['platform' => 'threads', 'akun' => 'https://threads.net/@unsia'],
        ]);

        $akun = $user->downline->socialMedia->pluck('akun', 'platform');

        $this->assertSame('unsia.my.id', $akun['instagram']);
        $this->assertSame('unsia', $akun['x']);
        $this->assertSame('unsia', $akun['threads']);
    }

    public function test_url_blog_disimpan_utuh(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'blog', 'akun' => 'https://blogsaya.id/'],
        ]);

        $media = $user->downline->socialMedia->first();

        $this->assertSame('https://blogsaya.id', $media->akun);
        $this->assertSame('https://blogsaya.id', $media->url());
    }

    public function test_tautan_dibentuk_dari_platform_dan_username(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
            ['platform' => 'tiktok', 'akun' => 'unsia'],
        ]);

        $url = $user->downline->socialMedia->mapWithKeys(fn ($m) => [$m->platform => $m->url()]);

        $this->assertSame('https://instagram.com/unsia.my.id', $url['instagram']);
        $this->assertSame('https://tiktok.com/@unsia', $url['tiktok']);
    }

    public function test_baris_kosong_tidak_disimpan(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
            ['platform' => 'facebook', 'akun' => ''],
            ['platform' => 'x', 'akun' => '   '],
        ]);

        $this->assertCount(1, $user->downline->socialMedia);
    }

    /**
     * Dua baris yang merujuk akun sama tidak boleh menabrak indeks unique.
     */
    public function test_baris_kembar_disatukan(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
            ['platform' => 'instagram', 'akun' => 'https://instagram.com/unsia.my.id'],
            ['platform' => 'instagram', 'akun' => '@unsia.my.id'],
        ]);

        $this->assertCount(1, $user->downline->socialMedia);
    }

    public function test_beberapa_akun_di_platform_yang_sama_boleh(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
            ['platform' => 'instagram', 'akun' => 'unsia.story'],
        ]);

        $this->assertCount(2, $user->downline->socialMedia);
    }

    public function test_baris_yang_dihapus_dari_form_ikut_terhapus(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
            ['platform' => 'tiktok', 'akun' => 'unsia'],
        ]);

        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $user), [
                'nama' => 'Mitra Satu',
                'email' => 'mitra1@contoh.id',
                'role' => 'downline',
                'status_downline' => 'aktif',
                'social_media' => [['platform' => 'instagram', 'akun' => 'unsia.my.id']],
            ])
            ->assertSessionHasNoErrors();

        $user->refresh()->load('downline.socialMedia');

        $this->assertCount(1, $user->downline->socialMedia);
        $this->assertSame('instagram', $user->downline->socialMedia->first()->platform);
    }

    /**
     * Baris yang isinya tidak berubah dipertahankan apa adanya, supaya tanggal
     * pencatatannya tidak ikut bergeser tiap kali form disimpan.
     */
    public function test_baris_yang_tidak_berubah_tidak_dibuat_ulang(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
        ]);

        $idAwal = $user->downline->socialMedia->first()->id;

        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $user), [
                'nama' => 'Mitra Satu Diubah',
                'email' => 'mitra1@contoh.id',
                'role' => 'downline',
                'status_downline' => 'aktif',
                'social_media' => [
                    ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
                    ['platform' => 'x', 'akun' => 'unsia'],
                ],
            ])
            ->assertSessionHasNoErrors();

        $user->refresh()->load('downline.socialMedia');

        $this->assertCount(2, $user->downline->socialMedia);
        $this->assertContains($idAwal, $user->downline->socialMedia->pluck('id')->all());
    }

    public function test_role_bukan_downline_tidak_menyimpan_sosial_media(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), [
                'nama' => 'Admin Dua',
                'email' => 'admin2@unsia.my.id',
                'role' => 'admin',
                'password' => 'rahasia123',
                'password_confirmation' => 'rahasia123',
                'social_media' => [['platform' => 'instagram', 'akun' => 'unsia.my.id']],
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('downline_social_media', 0);
    }

    public function test_sosial_media_ikut_terhapus_saat_downlinenya_hilang(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
        ]);

        $this->assertDatabaseCount('downline_social_media', 1);

        $this->actingAs($this->superadmin())
            ->delete(route('admin.users.destroy', $user));

        // users -> downlines -> downline_social_media, dua tingkat cascade.
        $this->assertDatabaseCount('downlines', 0);
        $this->assertDatabaseCount('downline_social_media', 0);
    }

    /**
     * Catatan sosial media tidak dihapus saat downline dinonaktifkan, sejalan
     * dengan id_downline yang juga dipertahankan.
     */
    public function test_sosial_media_bertahan_saat_downline_dinonaktifkan(): void
    {
        $user = $this->simpanDownline([
            ['platform' => 'instagram', 'akun' => 'unsia.my.id'],
        ]);

        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $user), [
                'nama' => 'Mitra Satu',
                'email' => 'mitra1@contoh.id',
                'role' => 'admin',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('downline_social_media', 1);
    }

    public function test_form_menampilkan_pilihan_platform(): void
    {
        $user = User::factory()->create(['role' => 'downline', 'email' => 'mitra@contoh.id']);
        Downline::buatUntuk($user);

        $response = $this->actingAs($this->superadmin())
            ->get(route('admin.users.edit', $user))
            ->assertStatus(200);

        foreach (DownlineSocialMedia::PLATFORM as $kunci => $meta) {
            $response->assertSee('value="' . $kunci . '"', false)
                ->assertSee($meta['label']);
        }
    }
}
