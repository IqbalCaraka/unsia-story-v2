<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanCashback extends Model
{
    protected $table = 'pengajuan_cashback';

    /** Status yang menghalangi pengajuan baru untuk periode yang sama. */
    public const STATUS_AKTIF = ['menunggu', 'diverifikasi', 'dibayar'];

    protected $fillable = [
        'user_id', 'tahun_ajar_id', 'metode', 'penyedia', 'nomor', 'atas_nama',
        'catatan', 'jumlah', 'status', 'catatan_admin', 'bukti_path', 'bukti_nama',
        'diverifikasi_oleh', 'diverifikasi_pada', 'dibayar_oleh', 'dibayar_pada',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'diverifikasi_pada' => 'datetime',
            'dibayar_pada' => 'datetime',
        ];
    }

    /**
     * Daftar bank yang bisa dipilih. Tambah atau kurangi di sini saja.
     *
     * @return array<int, string>
     */
    public static function daftarBank(): array
    {
        return [
            'BCA', 'BNI', 'BRI', 'Mandiri', 'BTN', 'BSI', 'CIMB Niaga',
            'Danamon', 'Permata', 'Panin', 'OCBC', 'Maybank', 'Bank Jago',
            'Seabank', 'Bank Neo Commerce', 'Blu by BCA Digital',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function daftarEwallet(): array
    {
        return ['DANA', 'OVO', 'GoPay', 'ShopeePay', 'LinkAja', 'Sakuku'];
    }

    public static function daftarPenyedia(string $metode): array
    {
        return $metode === 'ewallet' ? self::daftarEwallet() : self::daftarBank();
    }

    /**
     * Apakah mahasiswa ini masih punya klaim berjalan untuk periode tersebut.
     * Klaim yang ditolak tidak menghalangi pengajuan ulang.
     */
    public static function adaKlaimAktif(int $userId, int $tahunAjarId): bool
    {
        return static::where('user_id', $userId)
            ->where('tahun_ajar_id', $tahunAjarId)
            ->whereIn('status', self::STATUS_AKTIF)
            ->exists();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tahunAjar(): BelongsTo
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function pembayar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibayar_oleh');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isDiverifikasi(): bool
    {
        return $this->status === 'diverifikasi';
    }

    public function isDibayar(): bool
    {
        return $this->status === 'dibayar';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'diverifikasi' => 'Terverifikasi, menunggu transfer',
            'dibayar' => 'Sudah dibayar',
            'ditolak' => 'Ditolak',
            default => 'Menunggu verifikasi',
        };
    }

    public function statusWarna(): string
    {
        return match ($this->status) {
            'diverifikasi' => 'info',
            'dibayar' => 'success',
            'ditolak' => 'danger',
            default => 'warning',
        };
    }

    /**
     * "BCA 1234567890 a.n. Budi Santoso"
     */
    public function getTujuanAttribute(): string
    {
        return "{$this->penyedia} {$this->nomor} a.n. {$this->atas_nama}";
    }

    public function getJumlahRupiahAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->jumlah, 0, ',', '.');
    }
}
