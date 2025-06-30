<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = $this->faker->randomFloat(2, 100, 500);
        $isv = $subTotal * 0.15;
        $descuentos = $this->faker->randomFloat(2, 0, 50);
        $totalNeto = $subTotal + $isv - $descuentos;

        return [
            'numero' => $this->faker->unique()->numberBetween(1000, 9999),
            'fecha' => $this->faker->date(),
            'isv' => $isv,
            'sub_total' => $subTotal,
            'descuentos' => $descuentos,
            'total_neto' => $totalNeto,
            'usuario_comprante_id' => User::factory(),
        ];
    }
}
