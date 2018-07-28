<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPost(1, "Java is beautiful, isn't it", "test content");
        $this->createPost(1, "Laravel in action", "test content");
        $this->createPost(2, "Hello World", "test content");
        $this->createPost(2, "Java is beautiful 2", "test content");
    }

    private function createPost($userId, $title, $content)
    {
        $post = new Post;
        $post->user_id = $userId;
        $post->title = $title;
        $post->content = $content;
        $post->save();
    }
}
