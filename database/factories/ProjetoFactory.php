<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Localizacao;
use App\Models\Projeto;
use App\Models\TipoInstalacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conta>
 */
class ProjetoFactory extends Factory
{
    protected $model = Projeto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'nome' => $this->faker->unique()->words(3, true),
            'localizacao_id' =>  Localizacao::factory(),
            'tipo_instalacao_id' => TipoInstalacao::factory()->valid(),
        ];
    }
}
