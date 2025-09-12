<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('follows')->insert([
            'follower_id'  => 1,
            'following_id' => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

    }
}
