<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->insert([
            'user_id' => 1,
            'post_id' => 1,
            'body' => 'تعليق أول على المنشور',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
