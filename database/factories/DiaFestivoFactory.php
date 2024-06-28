<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiaFestivo>
 */
class DiaFestivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recurrente = $this->faker->boolean();
        return [
            'nombre' => $this->faker->words(3, true),
            'color' => $this->faker->hexColor(),
            'dia' => $this->faker->dayOfMonth(),
            'mes' => $this->faker->month(),
            'anio' => $recurrente ? null : $this->faker->year(),
            'recurrente' => $recurrente,
        ];
    }
}
