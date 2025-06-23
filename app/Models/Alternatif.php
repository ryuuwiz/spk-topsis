<?php

namespace App\Models;

use App\Services\TopsisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Alternatif extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'deskripsi'];

    protected $table = 'alternatif';

    /**
     * @return HasMany
     */
    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class, 'id_alternatif');
    }

    /**
     * Get TOPSIS score and rank for this alternative
     *
     * @return array|null
     */
    public function getTopsisRank(): ?array
    {
        $topsisService = new TopsisService();
        $rankings = $topsisService->hitungTopsis();

        foreach ($rankings as $ranking) {
            if ($ranking['id'] == $this->id) {
                return $ranking;
            }
        }

        return null;
    }
}
