<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Deposit;
use Faker\Generator as Faker;

$factory->define(Deposit::class, function (Faker $faker) {
    return [
        'shipper_id' => $faker->numberBetween(1,10),
        'deposit_day'=>$faker->dateTime(),
        'deposit_amount'=>$faker->numberBetween(100, 1000),
        'other'=>$faker->numberBetween(50, 100),
        'fee'=>$faker->numberBetween(50, 100),
        'delete_flg'=>0,
        'create_id' =>1,
        'created_at' =>$faker->dateTime,
        'update_id'=>1,
        'updated_at'=>$faker->dateTime,
    ];
});
