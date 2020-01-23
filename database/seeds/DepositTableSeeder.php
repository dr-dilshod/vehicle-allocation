<?php

use App\Deposit;
use Illuminate\Database\Seeder;

class DepositTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Deposit::class,50)->create();
    }
}
