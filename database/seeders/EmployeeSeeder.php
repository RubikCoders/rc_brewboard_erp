<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Admin user
        Employee::create([
            'id' => 1001,
            'user_id' => 7,
            'role_id' => 1001,
            'name' => 'Rodrigo',
            'last_name' => 'Sanchez',
            'birthdate' => '1990-05-15',
            'address' => 'Calle Violeta #1354 Col. Olimpica',
            'phone' => '3312658321',
            'emergency_contact' => '3388562582',
            'nss' => '97041216583',
            'entry_date' => '2024-02-23',
        ]);

//        Bartender User
        Employee::create([
            'id' => 1002,
            'user_id' => 504,
            'role_id' => 1002,
            'name' => 'Regina',
            'last_name' => 'Juarez',
            'birthdate' => '2002-10-20',
            'address' => 'Av. Javier Mina #358 Col. La Penal',
            'phone' => '3323246890',
            'emergency_contact' => '3312208473',
            'nss' => '97161836531',
            'entry_date' => '2025-02-20',
        ]);

//        Bartender user
        Employee::create([
            'id' => 1003,
            'user_id' => 104,
            'role_id' => 1002,
            'name' => 'Cinthia',
            'last_name' => 'Ramirez',
            'birthdate' => '2000-01-13',
            'address' => 'Calle Rio Poo #74 Col. El Periodista',
            'phone' => '3312448329',
            'emergency_contact' => '3321847404',
            'nss' => '92071523846',
            'entry_date' => '2024-08-04',
        ]);

        //        Bartender user
        Employee::create([
            'id' => 1004,
            'user_id' => 337,
            'role_id' => 1002,
            'name' => 'Antonio',
            'last_name' => 'Castañeda',
            'birthdate' => '2003-08-21',
            'address' => 'Calle Rio Bravo #1024 Col. Quinta Velarde',
            'phone' => '3317034096',
            'emergency_contact' => '3310188426',
            'nss' => '95090205463',
            'entry_date' => '2024-03-14',
        ]);
    }
}
