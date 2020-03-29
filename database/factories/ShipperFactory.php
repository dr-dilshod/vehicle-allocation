<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shipper;
use Faker\Generator as Faker;

$factory->define(Shipper::class, function (Faker $faker) {
    return [
        'shipper_no' => $faker->countryCode,
        'shipper_name1'=>$faker->name,
        'shipper_name2'=>$faker->name,
        'shipper_kana_name1'=>$faker->name,
        'shipper_kana_name2'=>$faker->name,
        'shipper_company_abbreviation'=>$faker->company,
        'postal_code'=> \Illuminate\Support\Str::limit($faker->postcode, 8, ''),
        'address1' => $faker->address,
        'address2' => $faker->address,
        'phone_number'=> \Illuminate\Support\Str::limit(''.$faker->phoneNumber, 12, ''),
        'fax_number'=> \Illuminate\Support\Str::limit(''.$faker->phoneNumber, 12, ''),
        'closing_date'=> $faker->numberBetween(0,10),
//        'payment_date'=> $faker->dateTime,
        'delete_flg'=>$faker->numberBetween(0,1),
        'create_id' =>1,
        'created_at' =>$faker->dateTime,
        'update_id'=>1,
        'updated_at'=>$faker->dateTime,
    ];
});
