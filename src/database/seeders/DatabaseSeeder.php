<?php

namespace Database\Seeders;

use App\Models\Follower;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create();
        Post::factory(100)->create();
        Like::factory(100)->create();
        Follower::factory(100)->create();

        $posts = (new Post())->withCount('likes')->get();
        foreach ($posts as $post) {
            $likeCount = $post->likes_count;
            $postModel = Post::find($post->id);
            $postModel->like_count = $likeCount;
            $postModel->save();
        }
    }
}
