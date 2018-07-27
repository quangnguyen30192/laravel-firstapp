<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrator',
        ]);

        DB::table('roles')->insert([
            'name' => 'User',
        ]);

        DB::table('roles')->insert([
            'name' => 'Super user',
        ]);
    }
}
