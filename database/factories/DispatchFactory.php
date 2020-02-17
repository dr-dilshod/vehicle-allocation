<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Vehicle;
use Faker\Generator as Faker;
use App\Driver;
use App\Item;

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

$factory->define(\App\Dispatch::class, function (Faker $faker) {
    return [
        'driver_id'=>Driver::orderBy('driver_id','DESC')->first()->driver_id,
        'item_id' => Item::orderBy('item_id','DESC')->first()->item_id,
        'timezone' => $faker->numberBetween(0,1),
        'delete_flg' => 0,
        'create_id' => 1,
        'update_id' => 1,
        'created_at' =>$faker->dateTime,
        'updated_at'=>$faker->dateTime
    ];
});
