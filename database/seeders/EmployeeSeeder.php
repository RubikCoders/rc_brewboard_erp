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

        Employee::create([
            'id' => 1005,
            'user_id' => 338,
            'role_id' => 1003,
            'name' => 'María',
            'last_name' => 'Hernández',
            'birthdate' => '1998-05-12',
            'address' => 'Av. Patria #456 Col. Lomas del Valle',
            'phone' => '3312458790',
            'emergency_contact' => '3319876543',
            'nss' => '98051209876',
            'entry_date' => '2024-04-10',
        ]);

        Employee::create([
            'id' => 1006,
            'user_id' => 339,
            'role_id' => 1003,
            'name' => 'Javier',
            'last_name' => 'Ramírez',
            'birthdate' => '2001-11-03',
            'address' => 'Calle Hidalgo #789 Col. Americana',
            'phone' => '3315648720',
            'emergency_contact' => '3332145879',
            'nss' => '01110305678',
            'entry_date' => '2024-05-02',
        ]);

        Employee::create([
            'id' => 1007,
            'user_id' => 340,
            'role_id' => 1003,
            'name' => 'Fernanda',
            'last_name' => 'Gómez',
            'birthdate' => '1999-02-18',
            'address' => 'Blvd. Chapultepec #321 Col. Moderna',
            'phone' => '3320178945',
            'emergency_contact' => '3336987452',
            'nss' => '99021807891',
            'entry_date' => '2024-06-20',
        ]);

        Employee::create([
            'id' => 1008,
            'role_id' => 1004,
            'name' => 'Ricardo',
            'last_name' => 'López',
            'birthdate' => '1997-09-14',
            'address' => 'Calle Morelos #652 Col. Centro',
            'phone' => '3332154879',
            'emergency_contact' => '3326987415',
            'nss' => '97091405623',
            'entry_date' => '2024-07-15',
        ]);

        Employee::create([
            'id' => 1009,
            'role_id' => 1005,
            'name' => 'Paola',
            'last_name' => 'Martínez',
            'birthdate' => '2000-12-25',
            'address' => 'Av. Juárez #120 Col. Obrera',
            'phone' => '3314789523',
            'emergency_contact' => '3339871254',
            'nss' => '00122507894',
            'entry_date' => '2024-08-05',
        ]);
    }
}
