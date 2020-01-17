<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('shipper_id');
            $table->integer('shipper_deposit');
            $table->integer('shipper_highway');
            $table->integer('vehicle_deposit');
            $table->integer('vehicle_highway');
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id');
            $table->unsignedBigInteger('update_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
