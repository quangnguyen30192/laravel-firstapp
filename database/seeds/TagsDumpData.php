<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTag("Java");
        $this->createTag("PHP");
        $this->createTag("C#");
    }

    private function createTag($name)
    {
        $tag = new Tag;
        $tag->name = $name;

        $tag->save();
    }
}
