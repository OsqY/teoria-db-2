<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compra>
 */
class CompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cantidad_total' => $this->faker->numberBetween(1, 100),
            'valor_de_compra' => $this->faker->randomFloat(2, 100, 1000),
            'proveedor_id' => Proveedor::factory(),
        ];
    }
}
