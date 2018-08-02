<?php

use App\Reply;
use Illuminate\Database\Seeder;

class RepliesDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reply::create(['comment_id' => 1,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);

        Reply::create(['comment_id' => 1,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);

        Reply::create(['comment_id' => 1,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);

        Reply::create(['comment_id' => 2,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);

        Reply::create(['comment_id' => 2,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);

        Reply::create(['comment_id' => 2,
                            'author' => 'Quang Nguyen',
                            'email' => 'quang@gmail.com',
                            'body' => 'that is easy for me']);

    }
}
