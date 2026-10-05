<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';

    public $timestamps = false;

    protected $fillable = [
        'prodi', 'kode_mk', 'nama_mk', 'sks', 'semester', 'kategori', 'peminatan', 'keywords',
    ];

    public function scopeBerbobot($query)
    {
        return $query->where('sks', '>', 0);
    }
}
