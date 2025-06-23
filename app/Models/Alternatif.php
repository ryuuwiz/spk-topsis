<?php

namespace App\Models;

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
     * Calculate TOPSIS ranking for all alternatives
     *
     * @return array
     */
    public static function calculateTopsisRanking(): array
    {
        // Get all alternatives, criteria, and ratings
        $alternatives = self::all();
        $criteria = Kriteria::all();

        if ($alternatives->isEmpty() || $criteria->isEmpty()) {
            return [];
        }

        // Create decision matrix
        $decisionMatrix = [];
        $alternativeIds = [];

        foreach ($alternatives as $alternative) {
            $alternativeIds[] = $alternative->id;
            $decisionMatrix[$alternative->id] = [];

            foreach ($criteria as $criterion) {
                $rating = Rating::where('id_alternatif', $alternative->id)
                    ->where('id_kriteria', $criterion->id)
                    ->first();

                $decisionMatrix[$alternative->id][$criterion->id] = $rating ? $rating->nilai : 0;
            }
        }

        // Step 1: Normalize the decision matrix
        $normalizedMatrix = [];

        foreach ($criteria as $criterion) {
            $sumOfSquares = 0;

            foreach ($alternatives as $alternative) {
                $sumOfSquares += pow($decisionMatrix[$alternative->id][$criterion->id], 2);
            }

            $denominator = sqrt($sumOfSquares);

            foreach ($alternatives as $alternative) {
                if (!isset($normalizedMatrix[$alternative->id])) {
                    $normalizedMatrix[$alternative->id] = [];
                }

                $normalizedMatrix[$alternative->id][$criterion->id] = $denominator != 0
                    ? $decisionMatrix[$alternative->id][$criterion->id] / $denominator
                    : 0;
            }
        }

        // Step 2: Calculate the weighted normalized decision matrix
        $weightedMatrix = [];

        foreach ($alternatives as $alternative) {
            $weightedMatrix[$alternative->id] = [];

            foreach ($criteria as $criterion) {
                $weightedMatrix[$alternative->id][$criterion->id] =
                    $normalizedMatrix[$alternative->id][$criterion->id] * $criterion->bobot;
            }
        }

        // Step 3: Determine the ideal and negative-ideal solutions
        $idealSolution = [];
        $negativeIdealSolution = [];

        foreach ($criteria as $criterion) {
            $values = [];

            foreach ($alternatives as $alternative) {
                $values[] = $weightedMatrix[$alternative->id][$criterion->id];
            }

            if ($criterion->atribut == 'benefit') {
                $idealSolution[$criterion->id] = max($values);
                $negativeIdealSolution[$criterion->id] = min($values);
            } else { // cost
                $idealSolution[$criterion->id] = min($values);
                $negativeIdealSolution[$criterion->id] = max($values);
            }
        }

        // Step 4: Calculate the separation measures
        $separationIdeal = [];
        $separationNegativeIdeal = [];

        foreach ($alternatives as $alternative) {
            $sumIdeal = 0;
            $sumNegativeIdeal = 0;

            foreach ($criteria as $criterion) {
                $sumIdeal += pow($weightedMatrix[$alternative->id][$criterion->id] - $idealSolution[$criterion->id], 2);
                $sumNegativeIdeal += pow($weightedMatrix[$alternative->id][$criterion->id] - $negativeIdealSolution[$criterion->id], 2);
            }

            $separationIdeal[$alternative->id] = sqrt($sumIdeal);
            $separationNegativeIdeal[$alternative->id] = sqrt($sumNegativeIdeal);
        }

        // Step 5: Calculate the relative closeness to the ideal solution
        $relativeCloseness = [];

        foreach ($alternatives as $alternative) {
            $denominator = $separationIdeal[$alternative->id] + $separationNegativeIdeal[$alternative->id];
            $relativeCloseness[$alternative->id] = $denominator != 0
                ? $separationNegativeIdeal[$alternative->id] / $denominator
                : 0;
        }

        // Step 6: Rank the alternatives
        $rankings = [];

        foreach ($alternatives as $alternative) {
            $rankings[] = [
                'id' => $alternative->id,
                'nama' => $alternative->nama,
                'score' => $relativeCloseness[$alternative->id]
            ];
        }

        // Sort by score in descending order
        usort($rankings, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Add rank
        $rank = 1;
        foreach ($rankings as &$ranking) {
            $ranking['rank'] = $rank++;
        }

        return $rankings;
    }

    /**
     * Get TOPSIS score and rank for this alternative
     *
     * @return array|null
     */
    public function getTopsisRank(): ?array
    {
        $rankings = self::calculateTopsisRanking();

        foreach ($rankings as $ranking) {
            if ($ranking['id'] == $this->id) {
                return $ranking;
            }
        }

        return null;
    }
}
