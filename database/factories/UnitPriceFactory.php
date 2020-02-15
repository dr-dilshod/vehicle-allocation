<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 14.02.2020
 * Time: 4:12
 */
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Shipper;
use App\Driver;
use App\UnitPrice;
use App\Item;
use Faker\Generator as Faker;

$factory->define(UnitPrice::class, function (Faker $faker) {
    return [
        'shipper_id' => Shipper::orderBy('shipper_id', 'DESC')->first()->shipper_id,
        'item_id' => Item::orderBy('item_id','DESC')->first()->item_id,
        'driver_id'=>Driver::orderBy('driver_id','DESC')->first()->driver_id,
        'type' => $faker->numberBetween(0,10),
        'price' => $faker->numberBetween(10, 100),
        'car_type' => $faker->randomElement($array= array('Blank', '10tW', '10t flat', '4tW', '4t flat', 'Controller')),
        'shipper_no' => $faker->countryCode,
        'stack_point' => $faker-> country(10, 100),
        'down_point' => $faker->country(100, 999),
        'delete_flg' => 0,
        'create_id' => 1,
        'update_id' => 1,
        'created_at' =>$faker->dateTime,
        'updated_at'=>$faker->dateTime


    ];
});
