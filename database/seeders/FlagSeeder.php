<?php

namespace Database\Seeders;

use App\Models\EconomicGroup;
use App\Models\Flag;
use Illuminate\Database\Seeder;

class FlagSeeder extends Seeder
{
    public function run(): void
    {
        // Criar flags para grupos existentes
        $economicGroups = EconomicGroup::all();
        
        if ($economicGroups->isEmpty()) {
            // Criar grupos se não existirem
            $economicGroups = EconomicGroup::factory()->count(3)->create();
        }

        // Criar 5 flags distribuídas entre os grupos
        Flag::factory()->count(5)->create([
            'economic_group_id' => function() use ($economicGroups) {
                return $economicGroups->random()->id;
            }
        ]);

        // Flags específicas para testes
        // Flag::factory()->withName('Supermercado ABC')->forEconomicGroup($economicGroups->first())->create();
        // Flag::factory()->withName('Hipermercado XYZ')->forEconomicGroup($economicGroups->last())->create();
    }
}