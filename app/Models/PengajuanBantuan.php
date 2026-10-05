<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBantuan extends Model
{
    protected $table = 'pengajuan_bantuan';

    protected $fillable = [
        'nama_lengkap', 'nim', 'email', 'whatsapp', 'prodi', 'ip_semester_1',
        'transkrip_path', 'transkrip_nama', 'motivasi_path', 'motivasi_nama',
        'catatan', 'status',
    ];

    protected function casts(): array
    {
        return [
            'ip_semester_1' => 'decimal:2',
        ];
    }

    /**
     * Daftar program studi yang bisa dipilih pemohon.
     *
     * @return array<int, string>
     */
    public static function daftarProdi(): array
    {
        return [
            'Sistem Informasi',
            'Informatika',
            'Manajemen',
            'Akuntansi',
            'Komunikasi',
            'Teknologi Informasi',
        ];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Menunggu Verifikasi',
        };
    }
}
