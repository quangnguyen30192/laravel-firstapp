<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Quang',
            'email' => str_random(10)."@gmail.com",
            'password' => bcrypt('Secret'),
            'is_active' => 1,
            'country_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Tam',
            'email' => str_random(10)."@gmail.com",
            'password' => bcrypt('Secret'),
            'country_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Minh',
            'email' => str_random(10)."@gmail.com",
            'password' => bcrypt('Secret'),
            'country_id' => 2,
        ]);


    }
}
