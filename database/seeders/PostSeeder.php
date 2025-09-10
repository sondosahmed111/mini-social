<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'هذا أول منشور',
            'image' => '',
            'video' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
