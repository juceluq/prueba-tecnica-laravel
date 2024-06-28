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
        return [
            'nombre' => fake()->name(),
            'color' => fake()->hexColor(),
            'dia' => fake()->dayOfMonth(),
            'mes' => fake()->month(),
            'anio' => fake()->year(),
            'recurrente' => fake()->boolean(),
        ];
    }
}
