<?php

namespace Database\Factories;

use App\Models\TipoInstalacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conta>
 */
class TipoInstalacaoFactory extends Factory
{
    protected $model = TipoInstalacao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->word,
        ];
    }

    public function valid(): static
    {
        return $this->state(fn (array $attributes) => [
            'nome' => 'Fibrocimento (Madeira)',
        ]);
    }
}
