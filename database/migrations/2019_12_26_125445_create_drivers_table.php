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
            $table->increments('driver_id');
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
