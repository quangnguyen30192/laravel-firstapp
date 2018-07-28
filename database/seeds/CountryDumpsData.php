<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountryDumpsData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCountry("Viet Nam");
        $this->createCountry("Usa");
        $this->createCountry("Cananda");
    }

    private function createCountry($name)
    {
        $country = new Country;
        $country->name = $name;
        $country->save();
    }
}
