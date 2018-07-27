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
         $this->call(UsersDumpData::class);
         $this->call(RolesDumpData::class);
         $this->call(RoleUserDumpData::class);
    }
}
