<?php

use App\Video;
use Illuminate\Database\Seeder;

class VideosDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createVideo("Java tutorial videos");
        $this->createVideo("PHP basic tutorial videos");
        $this->createVideo("Laravel basic tutorial videos");
    }

    private function createVideo($name)
    {
        $video = new Video;
        $video->name = $name;

        $video->save();
    }
}
