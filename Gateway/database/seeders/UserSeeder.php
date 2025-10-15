<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([        //10 REGISTROS DE GÉNERO
            [
                'role_id' => 1,
                'name' => 'Aleja',
                'email' => 'aleja@gmail.com',
                'password' => bcrypt('1234'),
                'account' => null

            ],
            [
                'role_id' => 2,
                'name' => 'Santiago',
                'email' => 'santi@gmail.com',
                'password' => bcrypt('1234'),
                'account' => null
            ],
            [
                'role_id' => 3,
                'name' => 'Diego',
                'email' => 'diego@gmail.com',
                'password' => bcrypt('1234'),
                'account' => 10000000
            ],
            [
                'role_id' => 3,
                'name' => 'Samuel',
                'email' => 'samuel@gmail.com',
                'password' => bcrypt('1234'),
                'account' => 700000
            ],
            [
                'role_id' => 3,
                'name' => 'Julian',
                'email' => 'julian@gmail.com',
                'password' => bcrypt('1234'),
                'account' => 6490000
            ]
        ]);
    }
}
