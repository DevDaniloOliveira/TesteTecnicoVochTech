<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuários de teste
        $adm = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@adm.com',
            'password' => bcrypt('admadm'), // senha padrão
        ]);
        
        $adm->assignRole('admin');
    }
}
