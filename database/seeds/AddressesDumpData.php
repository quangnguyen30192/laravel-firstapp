<?php

use App\Address;
use Illuminate\Database\Seeder;

class AddressesDumpData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAddress(1, '231 Le Duan, Da Nang');
        $this->createAddress(2, '12 Hai Phong, Da Nang');
        $this->createAddress(3, '98 Tran Phu, Da Nang');
    }

    private function createAddress($userId, $addressName)
    {
        $address = new Address;
        $address->user_id = $userId;
        $address->address = $addressName;

        $address->save();
    }
}
