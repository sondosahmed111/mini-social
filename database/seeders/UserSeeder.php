<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //users
        User::create([
            'name' => 'Menna Ahmed',
            'username' => 'menna123',
            'email' => 'menna@example.com',
            'password' => Hash::make('Password@123'),
        ]);

        User::create([
            'name' => 'Nada Mohamed',
            'username' => 'Nada123',
            'email' => 'nada@example.com',
            'password' => Hash::make('Password@123'),
        ]);
    }
}
