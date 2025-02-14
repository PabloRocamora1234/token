<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Ejecutar las semillas de la base de datos.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(60),
        ]);

        DB::table('users')->insert([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password456'),
            'remember_token' => Str::random(60),
        ]);
    }
}