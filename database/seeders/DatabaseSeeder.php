<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
            FollowSeeder::class,
        ]);
<<<<<<< HEAD

    }
=======
    
    $this->call(UsersTableSeeder::class);

>>>>>>> fca882307de5fcf6d0c78a5353103e51febc1915
}
    }

