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
            $table->bigIncrements('driver_id');
            $table->string('driver_no')->nullable();
            $table->string('driver_pass')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_mobile_number')->nullable();
            $table->string('maximum_Loading')->nullable();
            $table->tinyInteger('search_flg')->default(0);
            $table->tinyInteger('admin_flg')->default(0);
            $table->string('vehicle_no1')->nullable();
            $table->string('vehicle_no2')->nullable();
            $table->string('vehicle_no3')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('driver_remark')->nullable();
            $table->tinyInteger('delete_flg')->default(0);
            $table->bigInteger('create_id')->unsigned()->nullable();
            $table->bigInteger('update_id')->unsigned()->nullable();
            $table->timestamps();
            $table->index('create_id');
            $table->index('update_id');
            $table->foreign('create_id')->references('driver_id')->on('drivers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('update_id')->references('driver_id')->on('drivers')->onDelete('cascade')->onUpdate('cascade');
        });

        $driver = new \App\Driver();
        $driver->driver_no = '1';
        $driver->driver_name = 'admin';
        $driver->driver_pass = Hash::make('admin');
        $driver->admin_flg = 1;
        $driver->search_flg = 0;
        $driver->save();
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
