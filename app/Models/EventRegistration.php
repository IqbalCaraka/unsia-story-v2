<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id', 'nama', 'email', 'no_wa', 'asal_kota',
        'follow_verified', 'zoom_sent', 'reminder_sent', 'attended', 'sertif_sent',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
