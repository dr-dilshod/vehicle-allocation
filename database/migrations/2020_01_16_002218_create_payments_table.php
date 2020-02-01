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
            $table->index(['shipper_id', 'create_id', 'update_id']);
            $table->foreign('shipper_id')->references('shipper_id')->on('shippers')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('create_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('update_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');

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
