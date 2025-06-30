<?php

namespace Database\Factories;

use App\Models\Editorial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13,
            'editorial_id' => Editorial::factory(),
            'anio_publicacion' => $this->faker->date('Y-m-d', '2020-12-31'),
            'cantidad_disponible' => $this->faker->numberBetween(1, 20),
        ];
    }
}
