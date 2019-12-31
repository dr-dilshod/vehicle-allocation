<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Vehicle;
use Illuminate\Support\Str;
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
        'subcontract_no' => $faker->numberBetween(1,200),
        'company_name' => $faker->company,
        'company_kana_name' => $faker->company,
        'subcontract_company_abbreviation' => $faker->company,
        'subcontract_postal_code' => $faker->numberBetween(15000,75000),
        'subcontract_address1' => $faker->address,
        'subcontract_address2' => $faker->address,
        'subcontract_phone_number' => $faker->phoneNumber,
        'subcontract_fax_number' => $faker->phoneNumber,
        'offset' => $faker->numberBetween(0,9),
        'subcontract_remark' => $faker->sentence(10),
        'delete_flg' => $faker->numberBetween(0,1),
        'create_id' => 1,
        'update_id' => $faker->numberBetween(0,1),
    ];
});
