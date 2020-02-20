<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Driver;
use Faker\Generator as Faker;

$factory->define(Driver::class, function (Faker $faker) {
    return [
        'driver_no' => $faker->numberBetween(1000, 9999),
        'driver_pass' => Hash::make('12345'),
        'driver_name' => $faker->name,
        'driver_mobile_number' => $faker->phoneNumber,
        'maximum_Loading' => $faker->numberBetween(10, 100),
        'search_flg' => $faker->numberBetween(0,1),
        'admin_flg' => $faker-> numberBetween(0,1),
        'vehicle_no1' => $faker->numberBetween(10, 99),
        'vehicle_no2' => $faker-> numberBetween(100, 999),
        'vehicle_no3' => $faker->numberBetween(100, 999),
        'vehicle_type' => $faker->randomElement($array= array('10tW', '10t平', '4tW', '4t平', 'ﾄﾚｰﾗ', 'ﾊﾞﾙｸ')),
        'driver_remark' => $faker-> sentence(10),
        'delete_flg' => 0,
        'create_id' => 1,
        'update_id' => 1,
    ];
});
