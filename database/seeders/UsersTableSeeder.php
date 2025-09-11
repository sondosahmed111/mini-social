<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Mohamed Ahmed',
                'username' => 'mohamed',
                'email' => 'mohamed@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Sara Mohamed',
                'username' => 'sara',
                'email' => 'sara@example.com',
                'password' => bcrypt('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
