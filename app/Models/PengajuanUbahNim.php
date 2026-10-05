<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanUbahNim extends Model
{
    protected $table = 'pengajuan_ubah_nim';

    protected $fillable = [
        'user_id', 'nim_lama', 'nim_baru', 'alasan',
        'status', 'catatan_admin', 'diproses_oleh', 'diproses_pada',
    ];

    protected function casts(): array
    {
        return ['diproses_pada' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pemroses(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }
}
