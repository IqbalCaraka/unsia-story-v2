<?php

namespace Tests\Feature;

use App\Models\Downline;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DownlineTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $super = null;

    /**
     * Dipakai ulang dalam satu tes. Tanpa ini, pemanggilan kedua akan membuat
     * akun dengan email yang sama dan ditolak indeks unique.
     */
    protected function superadmin(): User
    {
        return $this->super ??= User::factory()->create([
            'role' => 'superadmin',
            'nama' => 'Super',
            'email' => 'super@unsia.my.id',
        ]);
    }

    protected function dataDasar(array $ganti = []): array
    {
        return array_merge([
            'nama' => 'Mitra Satu',
            'email' => 'mitra1@contoh.id',
            'role' => 'downline',
            'status_downline' => 'aktif',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ], $ganti);
    }

    public function test_downline_dibuat_beserta_baris_di_tabel_downlines(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar())
            ->assertRedirect(route('admin.users.index'));

        $user = User::where('email', 'mitra1@contoh.id')->firstOrFail();

        $this->assertSame('downline', $user->role);
        $this->assertNotNull($user->downline);
        $this->assertSame('aktif', $user->downline->status);
    }

    public function test_id_downline_delapan_angka(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar());

        $id = User::where('email', 'mitra1@contoh.id')->firstOrFail()->downline->id_downline;

        $this->assertMatchesRegularExpression('/^[0-9]{8}$/', $id);

        // Tidak boleh berawalan nol, karena nol di depan mudah hilang saat
        // nilainya dibaca sebagai bilangan.
        $this->assertNotSame('0', $id[0]);
    }

    public function test_kode_downline_dibentuk_dari_id_nya(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar());

        $dl = User::where('email', 'mitra1@contoh.id')->firstOrFail()->downline;

        $this->assertSame(Downline::AWALAN_KODE . $dl->id_downline, $dl->kode_downline);
    }

    public function test_id_downline_tidak_kembar(): void
    {
        $terpakai = [];

        for ($i = 1; $i <= 25; $i++) {
            $user = User::factory()->create(['role' => 'downline', 'nama' => "Mitra $i"]);
            $terpakai[] = Downline::buatUntuk($user)->id_downline;
        }

        $this->assertCount(25, array_unique($terpakai));
    }

    public function test_satu_akun_hanya_boleh_punya_satu_baris_downline(): void
    {
        $user = User::factory()->create(['role' => 'downline']);
        Downline::buatUntuk($user);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

        Downline::buatUntuk($user);
    }

    public function test_role_lain_tidak_membuat_baris_downline(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar([
                'role' => 'admin',
                'email' => 'admin2@unsia.my.id',
                'status_downline' => null,
            ]))
            ->assertSessionHasNoErrors();

        $user = User::where('email', 'admin2@unsia.my.id')->firstOrFail();

        $this->assertNull($user->downline);
        $this->assertDatabaseCount('downlines', 0);
    }

    public function test_downline_tidak_menyimpan_data_akademik(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar())
            ->assertSessionHasNoErrors();

        $user = User::where('email', 'mitra1@contoh.id')->firstOrFail();

        $this->assertNull($user->prodi_id);
        $this->assertNull($user->tahun_ajar_id);
        $this->assertNull($user->nim);
    }

    public function test_mahasiswa_wajib_mengisi_prodi_dan_tahun_ajar(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar([
                'role' => 'mahasiswa',
                'nim' => '2201234567',
                'email' => null,
                'status_downline' => null,
            ]))
            ->assertSessionHasErrors(['prodi_id', 'tahun_ajar_id']);
    }

    public function test_mahasiswa_tersimpan_saat_prodi_dan_tahun_ajar_diisi(): void
    {
        [$prodi, $tahun] = $this->prodiDanTahun();

        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar([
                'role' => 'mahasiswa',
                'nim' => '2201234567',
                'email' => null,
                'status_downline' => null,
                'prodi_id' => $prodi->id,
                'tahun_ajar_id' => $tahun->id,
            ]))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'nim' => '2201234567',
            'role' => 'mahasiswa',
            'prodi_id' => $prodi->id,
            'tahun_ajar_id' => $tahun->id,
        ]);
    }

    public function test_downline_wajib_punya_email_karena_tidak_punya_nim(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar(['email' => '']))
            ->assertSessionHasErrors('email');
    }

    public function test_status_downline_hanya_boleh_aktif_atau_tidak_aktif(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar(['status_downline' => 'entah']))
            ->assertSessionHasErrors('status_downline');
    }

    /**
     * Saat sebuah akun berhenti menjadi downline, barisnya dinonaktifkan dan
     * BUKAN dihapus — supaya id_downline-nya tetap sama kalau kelak ia
     * diaktifkan lagi. Angka itu mungkin sudah tersebar ke calon pendaftar.
     */
    public function test_id_downline_tetap_sama_setelah_dinonaktifkan_lalu_diaktifkan(): void
    {
        $this->actingAs($this->superadmin())
            ->post(route('admin.users.store'), $this->dataDasar());

        $user = User::where('email', 'mitra1@contoh.id')->firstOrFail();
        $idAwal = $user->downline->id_downline;
        $kodeAwal = $user->downline->kode_downline;

        // Jadi admin: baris downline dinonaktifkan, tidak dihapus.
        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $user), [
                'nama' => 'Mitra Satu',
                'role' => 'admin',
                'email' => 'mitra1@contoh.id',
            ])
            ->assertSessionHasNoErrors();

        $user->refresh();
        $this->assertSame('admin', $user->role);
        $this->assertNotNull($user->downline);
        $this->assertSame('tidak_aktif', $user->downline->status);

        // Dikembalikan jadi downline: ID dan kodenya harus yang lama.
        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $user), [
                'nama' => 'Mitra Satu',
                'role' => 'downline',
                'email' => 'mitra1@contoh.id',
                'status_downline' => 'aktif',
            ])
            ->assertSessionHasNoErrors();

        $user->refresh();
        $user->unsetRelation('downline');

        $this->assertSame($idAwal, $user->downline->id_downline);
        $this->assertSame($kodeAwal, $user->downline->kode_downline);
        $this->assertSame('aktif', $user->downline->status);
        $this->assertDatabaseCount('downlines', 1);
    }

    public function test_data_akademik_dibersihkan_saat_mahasiswa_jadi_downline(): void
    {
        [$prodi, $tahun] = $this->prodiDanTahun();

        $mahasiswa = User::factory()->create([
            'role' => 'mahasiswa',
            'nama' => 'Budi',
            'nim' => '2209999999',
            'email' => null,
            'prodi_id' => $prodi->id,
            'tahun_ajar_id' => $tahun->id,
        ]);

        $this->actingAs($this->superadmin())
            ->put(route('admin.users.update', $mahasiswa), [
                'nama' => 'Budi',
                'role' => 'downline',
                'email' => 'budi@contoh.id',
                'status_downline' => 'aktif',
            ])
            ->assertSessionHasNoErrors();

        $mahasiswa->refresh();

        $this->assertSame('downline', $mahasiswa->role);
        $this->assertNull($mahasiswa->nim);
        $this->assertNull($mahasiswa->prodi_id);
        $this->assertNull($mahasiswa->tahun_ajar_id);
        $this->assertNotNull($mahasiswa->downline);
    }

    public function test_baris_downline_ikut_terhapus_saat_akunnya_dihapus(): void
    {
        $user = User::factory()->create(['role' => 'downline']);
        Downline::buatUntuk($user);

        $this->assertDatabaseCount('downlines', 1);

        $this->actingAs($this->superadmin())
            ->delete(route('admin.users.destroy', $user));

        $this->assertDatabaseCount('downlines', 0);
    }

    public function test_downline_tidak_punya_akses_panel(): void
    {
        $user = User::factory()->create(['role' => 'downline', 'email' => 'mitra@contoh.id']);
        Downline::buatUntuk($user);

        $this->assertFalse($user->isPengelola());
        $this->assertTrue($user->isDownline());
        $this->assertFalse($user->isMahasiswa());

        // AdminAuth memantulkan non-pengelola ke halaman profilnya sendiri,
        // bukan memberi 403.
        $this->actingAs($user)->get('/admin')
            ->assertRedirect(route('profil.edit'));
    }

    /**
     * Sebelum ada role ini, label role memakai teks tetap dengan cabang
     * terakhir "Mahasiswa", sehingga downline akan salah tampil.
     */
    public function test_label_role_downline_benar(): void
    {
        $this->assertSame('Downline', User::factory()->create(['role' => 'downline'])->roleLabel());
    }

    public function test_form_menampilkan_opsi_downline_dan_blok_datanya(): void
    {
        $this->actingAs($this->superadmin())
            ->get(route('admin.users.create'))
            ->assertStatus(200)
            ->assertSee('value="downline"', false)
            ->assertSee('id="blokDownline"', false)
            ->assertSee('name="status_downline"', false)
            ->assertSee('ID Downline');
    }

    public function test_daftar_pengguna_menampilkan_id_dan_kode_downline(): void
    {
        $user = User::factory()->create([
            'role' => 'downline',
            'nama' => 'Mitra Terdaftar',
            'email' => 'mitra9@contoh.id',
        ]);
        $dl = Downline::buatUntuk($user);

        $this->actingAs($this->superadmin())
            ->get(route('admin.users.index', ['role' => 'downline']))
            ->assertStatus(200)
            ->assertSee('Mitra Terdaftar')
            ->assertSee('Downline')
            ->assertSee($dl->id_downline)
            ->assertSee($dl->kode_downline);
    }

    public function test_pencarian_mencakup_id_dan_kode_downline(): void
    {
        $user = User::factory()->create([
            'role' => 'downline',
            'nama' => 'Mitra Dicari',
            'email' => 'dicari@contoh.id',
        ]);
        $dl = Downline::buatUntuk($user);

        foreach ([$dl->id_downline, $dl->kode_downline] as $kataKunci) {
            $this->actingAs($this->superadmin())
                ->get(route('admin.users.index', ['q' => $kataKunci]))
                ->assertStatus(200)
                ->assertSee('Mitra Dicari');
        }
    }

    /** @return array{0: Prodi, 1: TahunAjar} */
    protected function prodiDanTahun(): array
    {
        return [
            Prodi::create(['nama_prodi' => 'Informatika', 'slug' => 'informatika']),
            TahunAjar::create([
                'tahun_ajar' => '2026/2027',
                'ganjil_genap' => 'ganjil',
                'nominal_cashback' => 150000,
            ]),
        ];
    }
}
