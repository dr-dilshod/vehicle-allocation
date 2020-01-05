<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_pass')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_mobile_number')->nullable();
            $table->string('maximum_Loading')->nullable();
            $table->tinyInteger('search_flg')->nullable();
            $table->tinyInteger('admin_flg')->nullable();
            $table->string('car_no1')->nullable();
            $table->string('car_no2')->nullable();
            $table->string('car_no3')->nullable();
            $table->string('car_type')->nullable();
            $table->string('driver_remark')->nullable();
            $table->tinyInteger('delete_flg')->nullable();
            $table->unsignedBigInteger('create_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->unsignedBigInteger('update_id')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->foreign('create_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('update_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::table('drivers')->insert([
            'driver_pass' => "12345",
            'driver_name' => 'Raximov Rashid',
            'driver_mobile_number' => '(97)360-1234',
            'maximum_Loading' => '50 Tn',
            'search_flg' => 1,
            'admin_flg' => 2,
            'car_no1' => '90',
            'car_no2' => '033',
            'car_no3' => 'RAA',
            'car_type' => 'Cobalt',
            'driver_remark' => 1
        ]);
        DB::table('drivers')->insert([
            'driver_pass' => "12345",
            'driver_name' => 'Axmedov Sardor',
            'driver_mobile_number' => '(97)360-1234',
            'maximum_Loading' => '50 Tn',
            'search_flg' => 1,
            'admin_flg' => 2,
            'car_no1' => '90',
            'car_no2' => '033',
            'car_no3' => 'RAA',
            'car_type' => 'Cobalt',
            'driver_remark' => 1
        ]);
        DB::table('drivers')->insert([
            'driver_pass' => "12345",
            'driver_name' => 'Sapayev Shodlik',
            'driver_mobile_number' => '(97)360-1234',
            'maximum_Loading' => '50 Tn',
            'search_flg' => 1,
            'admin_flg' => 2,
            'car_no1' => '90',
            'car_no2' => '033',
            'car_no3' => 'RAA',
            'car_type' => 'Cobalt',
            'driver_remark' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('drivers');
    }
}
