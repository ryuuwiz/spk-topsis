<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some predefined criteria
        $kriteria = [
            [
                'nama' => 'Perilaku',
                'bobot' => 0.2,
                'atribut' => 'benefit',
            ],
            [
                'nama' => 'Kerjasama Tim',
                'bobot' => 0.15,
                'atribut' => 'benefit',
            ],
            [
                'nama' => 'Kehadiran',
                'bobot' => 0.3,
                'atribut' => 'benefit',
            ],
            [
                'nama' => 'Produktifitas',
                'bobot' => 0.2,
                'atribut' => 'benefit',
            ],
            [
                'nama' => 'Kepemimpinan',
                'bobot' => 0.15,
                'atribut' => 'benefit',
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }

        // Create additional random criteria if needed
//        Kriteria::factory()->count(5)->create();
    }
}
