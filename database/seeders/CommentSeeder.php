<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('comments')->insert([
            'user_id' => 1, // Menna
            'post_id' => 1, // أول Post
            'body' => 'تعليق أول على المنشور',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
