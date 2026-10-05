<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjar extends Model
{
    protected $table = 'tahun_ajar';

    protected $fillable = ['ganjil_genap', 'tahun_ajar', 'nominal_cashback'];

    protected function casts(): array
    {
        return ['nominal_cashback' => 'decimal:2'];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function pengajuanCashback(): HasMany
    {
        return $this->hasMany(PengajuanCashback::class);
    }

    /** Periode dianggap membuka cashback kalau nominalnya di atas nol. */
    public function cashbackDibuka(): bool
    {
        return (float) $this->nominal_cashback > 0;
    }

    public function getNominalRupiahAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->nominal_cashback, 0, ',', '.');
    }

    /**
     * Label siap tampil, mis. "2025/2026 Ganjil".
     */
    public function getLabelAttribute(): string
    {
        return $this->tahun_ajar . ' ' . ucfirst($this->ganjil_genap);
    }
}
