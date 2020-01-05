<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shipper;
use Faker\Generator as Faker;

$factory->define(Shipper::class, function (Faker $faker) {
    return [
        'shipper_no' => $faker->name,
        'shipper_name1'=>$faker->name,
        'shipper_name2'=>$faker->name,
        'shipper_company_abbreviation'=>$faker->company,
        'address1' => $faker->address,
        'address2' => $faker->address,
        'phone_number'=> $faker->phoneNumber,
        'closing_date'=> $faker->numberBetween(0,10),
        'delete_flg'=>$faker->numberBetween(0,1),
        'create_id' =>1,
        'created_at' =>$faker->dateTime,
        'update_id'=>1,
        'updated_at'=>$faker->dateTime,
    ];
});
