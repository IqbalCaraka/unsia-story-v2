<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    /**
     * Pencairan cashback hanya lewat e-wallet, jadi metodenya selalu ini.
     *
     * Kolom `metode` tetap dipertahankan beserta nilai 'bank'-nya karena
     * pengajuan lama mungkin masih memakainya; yang berubah hanya pilihan
     * untuk pengajuan baru.
     */
    public const METODE = 'ewallet';

    /**
     * @return array<int, string>
     */
    /** Jenis berkas bukti yang bisa ditampilkan langsung di halaman. */
    private const GAMBAR = ['jpg', 'jpeg', 'png', 'webp'];

    public function buktiEkstensi(): ?string
    {
        if (! $this->bukti_nama) {
            return null;
        }

        return mb_strtolower(pathinfo($this->bukti_nama, PATHINFO_EXTENSION));
    }

    public function buktiGambar(): bool
    {
        return in_array($this->buktiEkstensi(), self::GAMBAR, true);
    }

    public function buktiPdf(): bool
    {
        return $this->buktiEkstensi() === 'pdf';
    }

    /** E-wallet yang dilayani untuk pencairan cashback. */
    public static function daftarEwallet(): array
    {
        return ['DANA', 'GoPay', 'ShopeePay'];
    }

    /**
     * Status yang berarti klaim sudah disetujui admin. Sekali mencapai salah
     * satunya, mahasiswa tidak boleh mengajukan lagi.
     */
    public const STATUS_DISETUJUI = ['diverifikasi', 'dibayar'];

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

    /**
     * Cashback adalah manfaat sekali seumur, bukan per periode: ia melekat
     * pada pemakaian kode referal saat mendaftar, dan itu terjadi satu kali.
     *
     * Karena itu klaim yang sudah disetujui mengunci fitur ini untuk
     * seterusnya, termasuk untuk periode lain.
     */
    public static function sudahPernahDisetujui(int $userId): bool
    {
        return static::where('user_id', $userId)
            ->whereIn('status', self::STATUS_DISETUJUI)
            ->exists();
    }

    /**
     * Klaim yang sedang diproses juga menahan pengajuan baru, supaya tidak ada
     * dua klaim berjalan sekaligus di periode yang berbeda.
     */
    public static function adaKlaimBerjalan(int $userId): bool
    {
        return static::where('user_id', $userId)
            ->whereIn('status', self::STATUS_AKTIF)
            ->exists();
    }

    /** Klaim yang mengunci fitur, kalau ada — untuk ditampilkan ke mahasiswa. */
    public static function klaimPengunci(int $userId): ?self
    {
        return static::where('user_id', $userId)
            ->whereIn('status', self::STATUS_AKTIF)
            ->latest('id')
            ->first();
    }

    /**
     * Apakah nama pemilik rekening sama dengan nama mahasiswa.
     *
     * Dibandingkan setelah dirapikan: huruf besar-kecil disamakan dan spasi
     * ganda dipadatkan. Keduanya hanya soal cara menulis, bukan nama yang
     * berbeda — "Budi  Santoso" dan "budi santoso" tetap orang yang sama.
     *
     * Selain itu dituntut sama persis, sesuai aturan yang berlaku: rekening
     * e-wallet harus atas nama mahasiswa sendiri.
     */
    public static function namaCocok(?string $atasNama, ?string $namaMahasiswa): bool
    {
        $rapikan = static fn (?string $n): string => mb_strtolower(
            preg_replace('/\s+/', ' ', trim((string) $n))
        );

        return $rapikan($atasNama) !== '' && $rapikan($atasNama) === $rapikan($namaMahasiswa);
    }

    public function log(): HasMany
    {
        return $this->hasMany(LogCashback::class, 'pengajuan_cashback_id')->oldest('id');
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
            'dibatalkan' => 'Dibatalkan',
            default => 'Menunggu verifikasi',
        };
    }

    public function statusWarna(): string
    {
        return match ($this->status) {
            'diverifikasi' => 'info',
            'dibayar' => 'success',
            'ditolak' => 'danger',
            'dibatalkan' => 'secondary',
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
