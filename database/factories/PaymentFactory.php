<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'shipper_id' => $faker->numberBetween(1,50),
        'payment_day' => $faker->date("Y-m-d"),
        'payment_amount' => $faker->randomElement($array= array(1000, 2000, 3000, 10000, 20000, 15000, 40000, 45000, 5000, 35000, 3000)),
        'other' => $faker->randomElement($array= array(1000, 2000, 3000, 10000, 20000, 15000, 40000, 45000, 5000, 35000, 3000)),
        'fee' => $faker->randomElement($array= array(1000, 2000, 3000, 10000, 20000, 15000, 40000, 45000, 5000, 35000, 3000)),
        'delete_flg'=>0,
        'create_id' =>1,
        'update_id'=>1,
    ];
});
