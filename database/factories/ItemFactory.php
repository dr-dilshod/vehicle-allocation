<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'shipper_id' => $faker->numberBetween(1,10),
        'driver_id' => $faker->numberBetween(1,10),
        'vehicle_no' => $faker->randomNumber(),
        'status' => $faker->numberBetween(0,1),
        'stack_date' => $faker->date(),
        'stack_time'=> $faker->time(),
        'down_date' => $faker->date(),
        'down_time' => $faker->time(),
        'down_invoice' => $faker->numberBetween(0,1),
        'stack_point' => $faker->address,
        'down_point'=>$faker->address,
        'weight'=>$faker->numberBetween(0, 100),
        'empty_pl'=>$faker->numberBetween(0,1),
        'item_price'=>$faker->numberBetween(0,100),
        'item_driver_name'=>$faker->name,
        'vehicle_no3' => $faker->numberBetween(100, 999),
        'shipper_name' => $faker->company,
        'item_vehicle' => $faker->companySuffix,
        'vehicle_payment'=>$faker->numberBetween(0,100),
        'item_completion_date'=>$faker->date(),
        'item_remark' => $faker->sentence(10),
        'delete_flg' => $faker->numberBetween(0,1),
        'create_id' => $faker->numberBetween(1,10),
        'update_id' => $faker->numberBetween(1,10),
        'remember_token' => $faker->address,
    ];
});
