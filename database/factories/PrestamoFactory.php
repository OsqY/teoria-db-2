<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaPrestamo = $this->faker->dateTimeBetween('-1 month', 'now');
        return [
            'user_id' => User::factory(),
            'fecha_prestamo' => $fechaPrestamo->format('Y-m-d'),
            'fecha_devolucion_esperada' => $this->faker->dateTimeBetween($fechaPrestamo, '+1 month')->format('Y-m-d'),
            'estado' => $this->faker->randomElement(['pendiente', 'devuelto', 'atrasado']),
            'fecha_devuelto' => $this->faker->optional()->dateTimeBetween($fechaPrestamo, 'now')->format('Y-m-d'),
        ];
    }
}
