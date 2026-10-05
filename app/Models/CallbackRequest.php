<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallbackRequest extends Model
{
    protected $fillable = [
        'nama', 'kontak', 'tanggal_hubungi', 'waktu_hubungi', 'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_hubungi' => 'date',
        ];
    }
}
