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
            $table->unsignedBigInteger('shipper_id');
            $table->dateTime('payment_day');
            $table->integer('payment_amount')->default(0);
            $table->integer('other')->default(0);
            $table->integer('fee')->default(0);
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id')->nullable();
            $table->unsignedBigInteger('update_id')->nullable();
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
