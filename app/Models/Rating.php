<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['id_alternatif', 'id_kriteria', 'nilai'];

    protected $table = 'rating';

    public function alternatif(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Alternatif::class, 'id_alternatif');
    }

    public function kriteria(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }
}
