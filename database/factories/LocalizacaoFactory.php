<?php

namespace Database\Factories;

use App\Models\Localizacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conta>
 */
class LocalizacaoFactory extends Factory
{
    protected $model = Localizacao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uf' => 'SP',
        ];
    }
}
