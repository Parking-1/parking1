<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nombre" => fake()->name(),
            "apellido" => fake()->name(),
            "cedula" => (string)(fake()->unique()->numberBetween(100, 200)),
            "telefono" => fake()->numberBetween(10000, 20000),
        ];
    }
}
