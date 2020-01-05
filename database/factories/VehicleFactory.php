<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Vehicle;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'vehicle_no' => $faker->numberBetween(1,200),
        'company_name' => $faker->company,
        'company_kana_name' => $faker->company,
        'vehicle_company_abbreviation' => $faker->company,
        'vehicle_postal_code' => $faker->numberBetween(15000,75000),
        'vehicle_address1' => $faker->address,
        'vehicle_address2' => $faker->address,
        'vehicle_phone_number' => $faker->phoneNumber,
        'vehicle_fax_number' => $faker->phoneNumber,
        'offset' => $faker->numberBetween(0,1),
        'vehicle_remark' => $faker->sentence(10),
        'delete_flg' => $faker->numberBetween(0,1),
        'create_id' => 1,
        'update_id' => $faker->numberBetween(0,1),
    ];
});
