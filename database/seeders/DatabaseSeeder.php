<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $authors = Author::factory(10)->create();

        $posts = Post::factory(100)->recycle($authors)->create();

        foreach($posts as $post) {
            Comment::factory(fake()->numberBetween(1,10))->recycle($post)->create();
        }
    }
}
