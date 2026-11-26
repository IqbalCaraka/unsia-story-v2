<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pengajuan_cashback_id', 'aksi', 'oleh_user_id', 'status_lama', 'status_baru', 'catatan'])]
class LogCashback extends Model
{
    protected $table = 'log_cashback';

    /** Baris log tidak pernah diubah, jadi updated_at tidak dipakai. */
    public const UPDATED_AT = null;

    /**
     * Satu-satunya daftar aksi yang sah. Kolomnya varchar biasa, jadi menambah
     * jenis peristiwa cukup di sini.
     */
    public const AKSI = [
        'diajukan' => 'Diajukan mahasiswa',
        'diverifikasi' => 'Diverifikasi admin',
        'dibayar' => 'Dibayar admin',
        'ditolak' => 'Ditolak admin',
        'dibatalkan' => 'Dibatalkan mahasiswa',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanCashback::class, 'pengajuan_cashback_id');
    }

    public function pelaku(): BelongsTo
    {
        return $this->belongsTo(User::class, 'oleh_user_id');
    }

    public function aksiLabel(): string
    {
        return self::AKSI[$this->aksi] ?? $this->aksi;
    }

    /**
     * Nama pelaku saat log ditampilkan. Akun yang sudah dihapus menyisakan
     * oleh_user_id null, dan lognya tetap harus terbaca.
     */
    public function pelakuNama(): string
    {
        return $this->pelaku?->nama ?? $this->pelaku?->name ?? 'akun telah dihapus';
    }

    /**
     * Mencatat satu peristiwa.
     *
     * Status lama diambil dari keadaan pengajuan SEBELUM diubah, jadi pemanggil
     * harus memanggil ini sebelum menyimpan status barunya — atau mengirimkan
     * status lamanya sendiri.
     */
    public static function catat(
        PengajuanCashback $pengajuan,
        string $aksi,
        ?int $olehUserId,
        ?string $statusLama,
        string $statusBaru,
        ?string $catatan = null,
    ): self {
        return static::create([
            'pengajuan_cashback_id' => $pengajuan->id,
            'aksi' => $aksi,
            'oleh_user_id' => $olehUserId,
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'catatan' => $catatan,
        ]);
    }
}
