<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'nim', 'nama', 'foto_profil', 'prodi_id', 'role', 'tahun_ajar_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }

    public function tahunAjar(): BelongsTo
    {
        return $this->belongsTo(TahunAjar::class);
    }

    /**
     * Data downline, hanya ada kalau rolenya downline. Dibuat dan dinonaktifkan
     * oleh UserController saat role diubah.
     */
    public function downline(): HasOne
    {
        return $this->hasOne(Downline::class);
    }

    public function pengajuanUbahNim(): HasMany
    {
        return $this->hasMany(PengajuanUbahNim::class);
    }

    public function pengajuanCashback(): HasMany
    {
        return $this->hasMany(PengajuanCashback::class);
    }

    /**
     * Pengajuan ubah NIM yang masih menunggu keputusan admin, kalau ada.
     */
    public function pengajuanNimMenunggu(): ?PengajuanUbahNim
    {
        return $this->pengajuanUbahNim()->menunggu()->latest('id')->first();
    }

    /**
     * URL foto profil, atau null kalau berkasnya tidak ada.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (! $this->foto_profil) {
            return null;
        }

        return asset($this->foto_profil);
    }

    /**
     * Inisial untuk avatar cadangan saat belum ada foto.
     */
    public function getInisialAttribute(): string
    {
        $nama = trim($this->nama ?? $this->name ?? '');

        if ($nama === '') {
            return '?';
        }

        $bagian = preg_split('/\s+/', $nama);

        return mb_strtoupper(mb_substr($bagian[0], 0, 1) . (count($bagian) > 1 ? mb_substr(end($bagian), 0, 1) : ''));
    }

    /** Role yang boleh membuka panel admin. */
    public const ROLE_PENGELOLA = ['superadmin', 'admin'];

    /** Seluruh role yang sah. Dipakai validasi agar tidak ada daftar kembar. */
    public const ROLE_SEMUA = ['superadmin', 'admin', 'mahasiswa', 'downline'];

    /**
     * Role yang masuk memakai email, bukan NIM. Downline ikut di sini karena
     * bukan mahasiswa dan tidak punya NIM, walau ia bukan pengelola panel.
     */
    public const ROLE_LOGIN_EMAIL = ['superadmin', 'admin', 'downline'];

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Admin maupun superadmin. Dipakai untuk hal yang berlaku bagi
     * keduanya: akses panel, wajib punya email, arah redirect setelah login.
     */
    public function isPengelola(): bool
    {
        return in_array($this->role, self::ROLE_PENGELOLA, true);
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isDownline(): bool
    {
        return $this->role === 'downline';
    }

    /**
     * Role yang menyimpan data akademik (NIM, prodi, tahun ajar). Hanya
     * mahasiswa; downline dan pengelola tidak.
     */
    public function punyaDataAkademik(): bool
    {
        return $this->isMahasiswa();
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'downline' => 'Downline',
            'mahasiswa' => 'Mahasiswa',
            default => $this->role,
        };
    }

    public function scopeMahasiswa($query)
    {
        return $query->where('role', 'mahasiswa');
    }

    public function scopeDownline($query)
    {
        return $query->where('role', 'downline');
    }
}
