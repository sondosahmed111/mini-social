<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //posts
        $menna = User::where('email', 'menna@example.com')->first();
        $nada  = User::where('email', 'nada@example.com')->first();

        Post::create([
            'title' => 'My First Post',
            'description' => 'This is Menna’s first post.',
            'user_id' => $menna->id,
        ]);

        Post::create([
            'title' => 'Learning Laravel',
            'description' => 'Menna is exploring relationships in Laravel.',
            'user_id' => $menna->id,
        ]);

        Post::create([
            'title' => 'Hello World',
            'description' => 'This is Nada’s first post.',
            'user_id' => $nada->id,
        ]);
    }
}
