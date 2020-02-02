<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Driver;
use Faker\Generator as Faker;

$factory->define(Driver::class, function (Faker $faker) {
    return [
        'driver_pass' => $faker->password(10),
        'driver_name' => $faker->name,
        'driver_mobile_number' => $faker->phoneNumber,
        'maximum_Loading' => $faker->numberBetween(10, 100),
        'search_flg' => $faker->numberBetween(0,1),
        'admin_flg' => $faker-> numberBetween(0,1),
        'vehicle_no1' => $faker->numberBetween(10, 99),
        'vehicle_no2' => $faker-> numberBetween(100, 999),
        'vehicle_no3' => $faker->numberBetween(100, 999),
        'vehicle_type' => $faker->randomElement($array= array('Blank', '10tW', '10t flat', '4tW', '4t flat', 'Controller', 'Back')),
        'driver_remark' => $faker-> sentence(10),
        'delete_flg' => 0,
        'create_id' => 1,
        'update_id' => 1,
    ];
});
