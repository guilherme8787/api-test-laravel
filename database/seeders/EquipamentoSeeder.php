<?php

namespace Database\Seeders;

use App\Models\Equipamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipamentos = [
            'Módulo',
            'Inversor',
            'Microinversor',
            'Estrutura',
            'Cabo vermelho',
            'Cabo preto',
            'String Box',
            'Cabo Tronco',
            'Endcap',
        ];

        foreach ($equipamentos as $equipamento) {
            Equipamento::create(['nome' => $equipamento]);
        }
    }
}
