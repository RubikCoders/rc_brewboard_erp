<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 7,
            'name' => 'Administrador',
            'email' => 'admin@brewboard.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'id' => 504,
            'name' => 'Regina Juarez',
            'email' => 'rjuarez@brewboard.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'id' => 104,
            'name' => 'Cinthia Ramirez',
            'email' => 'cramirez@brewboard.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'id' => 610,
            'name' => 'Jorgue Contreras',
            'email' => 'jcontreras@brewboard.com',
            'password' => bcrypt('password')
        ]);

        User::create([
            'id' => 337,
            'name' => 'Antonio Castañeda',
            'email' => 'acastaneda@brewboard.com',
            'password' => bcrypt('password')
        ]);

    }
}
