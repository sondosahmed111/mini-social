<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    public function run()
    {
        DB::table('reactions')->insert([
            'user_id'    => 1,
            'post_id'    => 1,
            'type'       => 'like', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
