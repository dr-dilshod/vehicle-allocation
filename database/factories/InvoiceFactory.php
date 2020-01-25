<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'item_id'=>$faker->numberBetween(1, 10),
        'shipper_id'=>$faker->numberBetween(1, 10),
        'vehicle_id'=>$faker->numberBetween(1, 10),
        'payment_record_date'=>$faker->dateTime(),
        'invoice_remark'=>$faker->text(50),
        'delete_flg'=>0,
        'create_id' =>1,
        'created_at' =>$faker->dateTime,
        'update_id'=>1,
        'updated_at'=>$faker->dateTime,
    ];
});
