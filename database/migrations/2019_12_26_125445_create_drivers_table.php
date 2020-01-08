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
            $table->string('driver_pass')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_mobile_number')->nullable();
            $table->string('maximum_Loading')->nullable();
            $table->tinyInteger('search_flg')->nullable();
            $table->tinyInteger('admin_flg')->nullable();
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
