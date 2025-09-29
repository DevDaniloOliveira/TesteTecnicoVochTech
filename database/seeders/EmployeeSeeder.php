<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Unit;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Criar colaboradores para unidades existentes
        $units = Unit::all();

        if ($units->isEmpty()) {
            // Criar unidades se não existirem
            $units = Unit::factory()->count(3)->create();
        }

        // Criar 12 colaboradores distribuídos entre as unidades
        Employee::factory()->count(12)->create([
            'unit_id' => function() use ($units) {
                return $units->random()->id;
            }
        ]);

        // Colaboradores específicos para testes
        Employee::factory()->withName('João da Silva')->forUnit($units->first())->create();
        Employee::factory()->withName('Maria Oliveira')->forUnit($units->last())->create();
    }
}
