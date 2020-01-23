<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             VehicleTableSeeder::class,
             ShipperTableSeeder::class,
             DriverTableSeeder::class,
             ItemTableSeeder::class,
             DepositTableSeeder::class,
         ]);
    }
}
