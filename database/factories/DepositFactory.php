<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shipper;
use Faker\Generator as Faker;

$factory->define(Shipper::class, function (Faker $faker) {
    return [
        'invoice_id' => $faker->numberBetween(1,10),
        'deposit_amount'=>$faker->numberBetween(100, 1000),
        'fee'=>$faker->numberBetween(50, 100),
        'deposit_remark'=>$faker->text(50),
        'delete_flg'=>0,
        'create_id' =>1,
        'created_at' =>$faker->dateTime,
        'update_id'=>1,
        'updated_at'=>$faker->dateTime,
    ];
});
