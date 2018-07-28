<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RolesDumpData::class);
         $this->call(CountryDumpsData::class);
         $this->call(UsersDumpData::class);
         $this->call(RoleUserDumpData::class);
         $this->call(PostsDumpData::class);
         $this->call(PhotosDumpData::class);
         $this->call(TagsDumpData::class);
         $this->call(VideosDumpData::class);
         $this->call(TaggablesDumpData::class);
    }
}
