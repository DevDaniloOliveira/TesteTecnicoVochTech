<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Flag;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        // Criar unidades para bandeiras existentes
        $flags = Flag::all();

        if ($flags->isEmpty()) {
            // Criar bandeiras se não existirem
            $flags = Flag::factory()->count(3)->create();
        }

        // Criar 8 unidades distribuídas entre as bandeiras
        Unit::factory()->count(8)->create([
            'flag_id' => function() use ($flags) {
                return $flags->random()->id;
            }
        ]);

        // Unidades específicas para testes
        Unit::factory()->withFantasyName('Supermercado Central')->forFlag($flags->first())->create();
        Unit::factory()->withFantasyName('Hipermercado Sul')->forFlag($flags->last())->create();
    }
}
