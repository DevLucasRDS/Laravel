<?php

namespace Database\Seeders;

use App\Models\SituacaoConta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SituacaoContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SituacaoConta::create(['nome' => 'Pago', 'cor' => 'success']);
        SituacaoConta::create(['nome' => 'Pendente', 'cor' => 'danger']);
        SituacaoConta::create(['nome' => 'Atrasado', 'cor' => 'warning']);
    }
}
