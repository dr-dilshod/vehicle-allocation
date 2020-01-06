<?php

use App\Shipper;
use Illuminate\Database\Seeder;

class ShipperTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Shipper::class,50)->create();
    }
}
