<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'nama_event', 'deskripsi', 'tanggal_event', 'jam_event', 'lokasi',
        'poster', 'kuota', 'link_zoom', 'link_materi', 'link_sertif',
        'status', 'presensi_status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_event' => 'date',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }
}
