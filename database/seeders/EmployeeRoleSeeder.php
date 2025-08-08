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
            'name' => 'Barista matutino',
            'description' => 'Personal que atiende a los clientes y prepara los pedidos, encargado de la apertura de la sucursal'
        ]);

        EmployeeRole::create([
            'name' => 'Barista vespertino',
            'description' => 'Personal que atiende a los clientes y prepara los pedidos, encargado del cierre de la sucursal'
        ]);

        EmployeeRole::create([
            'name' => 'Limpieza',
            'description' => 'Personal encargado de limpiar la sucursal'
        ]);

        EmployeeRole::create([
            'name' => 'Mantenimiento',
            'description' => 'Personal que realiza el mantenimiento de la sucursal'
        ]);

    }
}
