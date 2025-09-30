<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Criar permissões (opcional - para granularidade futura)
        Permission::create(['name' => 'view_reports']);
        Permission::create(['name' => 'manage_users']);
        // ... outras permissões

        // Atribuir permissões às roles
        $adminRole->givePermissionTo(Permission::all());
        // $userRole->givePermissionTo(['view_reports']);
    }
}
