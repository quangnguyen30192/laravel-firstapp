<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentsDumpData extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Comment::create(['post_id' => 1,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);
        Comment::create(['post_id' => 1,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);
        Comment::create(['post_id' => 1,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);
        Comment::create(['post_id' => 2,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);
        Comment::create(['post_id' => 2,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);
        Comment::create(['post_id' => 2,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);
    }
}
