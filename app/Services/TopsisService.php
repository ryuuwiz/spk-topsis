<?php

namespace App\Services;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Rating;
use Illuminate\Support\Collection;

class TopsisService
{
    private Collection $alternatives;
    private Collection $criteria;
    private array $matriksKeputusan = [];
    private array $matriksTernormalisasi = [];
    private array $matriksTerbobot = [];
    private array $solusiIdealPositif = [];
    private array $solusiIdealNegatif = [];
    private array $jarakIdealPositif = [];
    private array $jarakIdealNegatif = [];
    private array $kedekatanRelatif = [];

    /**
     * Menghitung peringkat TOPSIS untuk semua alternatif.
     *
     * @return array
     */
    public function hitungTopsis(): array
    {
        $this->muatData();

        if ($this->alternatives->isEmpty() || $this->criteria->isEmpty()) {
            return [];
        }

        $this->buatMatriksKeputusan();
        $this->normalisasiMatriks();
        $this->hitungMatriksTerbobot();
        $this->tentukanSolusiIdeal();
        $this->hitungJarakSeparasi();
        $this->hitungKedekatanRelatif();

        return $this->buatPeringkat();
    }

    /**
     * Muat data awal dari database.
     */
    private function muatData(): void
    {
        $this->alternatives = Alternatif::all();
        $this->criteria = Kriteria::all();
    }

    /**
     * Langkah 1: Membuat matriks keputusan (X) dari data rating.
     */
    private function buatMatriksKeputusan(): void
    {
        foreach ($this->alternatives as $alternative) {
            foreach ($this->criteria as $criterion) {
                $rating = Rating::where('id_alternatif', $alternative->id)
                    ->where('id_kriteria', $criterion->id)
                    ->first();
                $this->matriksKeputusan[$alternative->id][$criterion->id] = $rating ? $rating->nilai : 0;
            }
        }
    }

    /**
     * Langkah 2: Normalisasi matriks keputusan (R).
     */
    private function normalisasiMatriks(): void
    {
        $pembagi = [];
        foreach ($this->criteria as $criterion) {
            $jumlahKuadrat = 0;
            foreach ($this->alternatives as $alternative) {
                $jumlahKuadrat += pow($this->matriksKeputusan[$alternative->id][$criterion->id], 2);
            }
            $pembagi[$criterion->id] = sqrt($jumlahKuadrat);
        }

        foreach ($this->alternatives as $alternative) {
            foreach ($this->criteria as $criterion) {
                $this->matriksTernormalisasi[$alternative->id][$criterion->id] = $pembagi[$criterion->id] != 0
                    ? $this->matriksKeputusan[$alternative->id][$criterion->id] / $pembagi[$criterion->id]
                    : 0;
            }
        }
    }

    /**
     * Langkah 3: Hitung matriks keputusan ternormalisasi terbobot (Y).
     */
    private function hitungMatriksTerbobot(): void
    {
        foreach ($this->alternatives as $alternative) {
            foreach ($this->criteria as $criterion) {
                $this->matriksTerbobot[$alternative->id][$criterion->id] =
                    $this->matriksTernormalisasi[$alternative->id][$criterion->id] * $criterion->bobot;
            }
        }
    }

    /**
     * Langkah 4: Tentukan solusi ideal positif (A+) dan negatif (A-).
     */
    private function tentukanSolusiIdeal(): void
    {
        foreach ($this->criteria as $criterion) {
            $nilaiKolom = array_column($this->matriksTerbobot, $criterion->id);

            if (empty($nilaiKolom)) {
                $this->solusiIdealPositif[$criterion->id] = 0;
                $this->solusiIdealNegatif[$criterion->id] = 0;
                continue;
            }

            if ($criterion->atribut == 'benefit') {
                $this->solusiIdealPositif[$criterion->id] = max($nilaiKolom);
                $this->solusiIdealNegatif[$criterion->id] = min($nilaiKolom);
            } else { // cost
                $this->solusiIdealPositif[$criterion->id] = min($nilaiKolom);
                $this->solusiIdealNegatif[$criterion->id] = max($nilaiKolom);
            }
        }
    }

    /**
     * Langkah 5: Hitung jarak separasi (D+ dan D-).
     */
    private function hitungJarakSeparasi(): void
    {
        foreach ($this->alternatives as $alternative) {
            $jumlahIdealPositif = 0;
            $jumlahIdealNegatif = 0;
            foreach ($this->criteria as $criterion) {
                $jumlahIdealPositif += pow($this->matriksTerbobot[$alternative->id][$criterion->id] - $this->solusiIdealPositif[$criterion->id], 2);
                $jumlahIdealNegatif += pow($this->matriksTerbobot[$alternative->id][$criterion->id] - $this->solusiIdealNegatif[$criterion->id], 2);
            }
            $this->jarakIdealPositif[$alternative->id] = sqrt($jumlahIdealPositif);
            $this->jarakIdealNegatif[$alternative->id] = sqrt($jumlahIdealNegatif);
        }
    }

    /**
     * Langkah 6: Hitung kedekatan relatif terhadap solusi ideal (V).
     */
    private function hitungKedekatanRelatif(): void
    {
        foreach ($this->alternatives as $alternative) {
            $penyebut = $this->jarakIdealPositif[$alternative->id] + $this->jarakIdealNegatif[$alternative->id];
            $this->kedekatanRelatif[$alternative->id] = $penyebut != 0
                ? $this->jarakIdealNegatif[$alternative->id] / $penyebut
                : 0;
        }
    }

    /**
     * Langkah 7: Buat dan urutkan peringkat akhir alternatif.
     *
     * @return array
     */
    private function buatPeringkat(): array
    {
        $peringkat = [];
        foreach ($this->alternatives as $alternative) {
            $peringkat[] = [
                'id' => $alternative->id,
                'nama' => $alternative->nama,
                'skor' => $this->kedekatanRelatif[$alternative->id]
            ];
        }

        // Urutkan berdasarkan skor secara descending
        usort($peringkat, fn ($a, $b) => $b['skor'] <=> $a['skor']);

        // Tambahkan nomor peringkat
        $rank = 1;
        foreach ($peringkat as &$p) {
            $p['peringkat'] = $rank++;
        }

        return $peringkat;
    }
}
