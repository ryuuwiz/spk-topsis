<?php

namespace Database\Factories;

use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kriteria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->unique()->word(),
            'bobot' => $this->faker->randomFloat(2, 0.1, 1.0),
            'atribut' => $this->faker->randomElement(['benefit', 'cost']),
        ];
    }
}
