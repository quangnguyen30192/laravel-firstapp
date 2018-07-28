<?php

use App\Photo;
use Illuminate\Database\Seeder;

class PhotosDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPhoto('car.jpg', 1, 'App\User');
        $this->createPhoto('model.jpg', 1, 'App\User');
        $this->createPhoto('beauty.jpg', 2, 'App\Post');
    }

    private function createPhoto($path, $imagableId, $imagableType)
    {
        $photo = new Photo;
        $photo->path = $path;
        $photo->imageable_id = $imagableId;
        $photo->imageable_type = $imagableType;
        $photo->save();
    }
}
