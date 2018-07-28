<?php

use App\Taggable;
use Illuminate\Database\Seeder;

class TaggablesDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTaggable(1, 1, 'App\Post');
        $this->createTaggable(1, 2, 'App\Post');
        $this->createTaggable(2, 1, 'App\Video');
        $this->createTaggable(2, 1, 'App\Video');
    }

    private function createTaggable($tagId, $taggableId, $taggableType){
        $taggable = new Taggable;
        $taggable->tag_id = $tagId;
        $taggable->taggable_id = $taggableId;
        $taggable->taggable_type = $taggableType;

        $taggable->save();
    }

}
