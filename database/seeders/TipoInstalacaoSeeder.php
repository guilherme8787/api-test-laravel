<?php

namespace Database\Seeders;

use App\Models\TipoInstalacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoInstalacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Fibrocimento (Madeira)',
            'Fibrocimento (Metálico)',
            'Cerâmico',
            'Metálico',
            'Laje',
            'Solo',
        ];

        foreach ($tipos as $tipo) {
            TipoInstalacao::create(['nome' => $tipo]);
        }
    }
}
