<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'bobot',
        'atribut',
    ];

    protected $table = 'kriteria';

    /**
     * @return HasMany
     */
    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
