<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;
$factory->define(Item::class, function (Faker $faker) {
$carbon = new \Carbon\Carbon();
    return [
        'shipper_id' => $faker->numberBetween(1,10),
        'driver_id' => $faker->numberBetween(1,10),
        'vehicle_id' => $faker->numberBetween(1,10),
        'status' => $faker->numberBetween(0,1),
        'stack_date' => $carbon->today(),
        'stack_time'=> $faker->time(),
        'down_date' => $carbon->next(1),
        'down_time' => $faker->time(),
        'down_invoice' => $faker->numberBetween(0,1),
        'stack_point' => $faker->city,
        'down_point'=>$faker->city,
        'weight'=>$faker->numberBetween(0, 100),
        'empty_pl'=>$faker->numberBetween(0,1),
        'item_price'=>$faker->numberBetween(0,100),
        'item_driver_name'=>$faker->name,
        'vehicle_no3' => $faker->numberBetween(100, 999),
        'shipper_name' => $faker->company,
        'item_vehicle' => $faker->companySuffix,
        'vehicle_payment'=>$faker->numberBetween(0,100),
        'highway_cost'=>$faker->numberBetween(0,100),
        'pay_highway_cost'=>$faker->numberBetween(0,100),
        'item_completion_date'=>$faker->date(),
        'item_remark' => $faker->text(15),
        'delete_flg' => $faker->numberBetween(0,1),
        'create_id' => 1,
        'update_id' => 1,
        'remember_token' => $faker->randomAscii,
    ];
});
