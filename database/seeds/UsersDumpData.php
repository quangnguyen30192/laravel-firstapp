<?php

use Carbon\Carbon;
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
            'created_at' => Carbon::now()->subDay(5),
            'updated_at' => Carbon::now()->subDay(5),
            'country_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Tam',
            'email' => str_random(10)."@gmail.com",
            'password' => bcrypt('Secret'),
            'created_at' => Carbon::now()->subDay(4),
            'updated_at' => Carbon::now()->subDay(4),
            'country_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Minh',
            'email' => str_random(10)."@gmail.com",
            'password' => bcrypt('Secret'),
            'created_at' => Carbon::now()->subDay(3),
            'updated_at' => Carbon::now()->subDay(3),
            'country_id' => 2,
        ]);


    }
}
