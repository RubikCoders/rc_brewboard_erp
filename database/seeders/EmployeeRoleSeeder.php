<?php

namespace Database\Seeders;

use App\Models\EmployeeRole;
use Illuminate\Database\Seeder;

class EmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeRole::create([
            'name' => 'Administrador',
            'description' => 'Personal administrativo'
        ]);

        EmployeeRole::create([
            'name' => 'Bartender',
            'description' => 'Personal que atiende a los clientes y prepara los pedidos'
        ]);

    }
}
