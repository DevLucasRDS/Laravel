<?php

namespace Database\Seeders;

use App\Models\Conta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Conta::where('nome', 'Energia')->first()) {
            Conta::create([
                'nome' => 'Energia',
                'valor' => 147.152,
                'vencimento' => '2025-12-23'
            ]);
        }
        if (!Conta::where('nome', 'Agua')->first()) {
            Conta::create([
                'nome' => 'Agua',
                'valor' => 104.45,
                'vencimento' => '2025-11-15'
            ]);
        }
        Conta::firstOrCreate(
            ['nome' => 'Internet'],
            ['valor' => 120.00, 'vencimento' => '2026-01-10']
        );
        Conta::firstOrCreate(
            ['nome' => 'Prestação A1'],
            ['valor' => 150.00, 'vencimento' => '2025-11-7']
        );
        Conta::firstOrCreate(
            ['nome' => 'Prestação A2'],
            ['valor' => 150.00, 'vencimento' => '2025-12-7']
        );
        Conta::firstOrCreate(
            ['nome' => 'Gás'],
            ['valor' => 100.00, 'vencimento' => '2025-8-12']
        );
        Conta::firstOrCreate(
            ['nome' => 'Celular'],
            ['valor' => 240.00, 'vencimento' => '2025-9-7']
        );
    }
}
