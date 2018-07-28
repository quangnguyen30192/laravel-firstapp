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
        $this->createPost( "Java is beautiful, isn't it", "test content");
        $this->createPost("Laravel in action", "test content");
        $this->createPost( "Hello World", "test content");
        $this->createPost( "Java is beautiful 2", "test content");
    }

    private function createPost($title, $content)
    {
        $post = new Post;
        $post->title = $title;
        $post->content = $content;
        $post->save();
    }
}
