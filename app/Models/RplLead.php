<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RplLead extends Model
{
    protected $fillable = [
        'nama', 'email', 'whatsapp', 'sumber', 'prodi_cocok', 'jenis_rpl', 'input_mk',
    ];
}
