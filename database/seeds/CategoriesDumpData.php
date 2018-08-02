<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'PHP']);
        Category::create(['name' => 'Java']);
        Category::create(['name' => 'C#']);
        Category::create(['name' => 'Spring']);
        Category::create(['name' => 'Laravel']);
    }
}
