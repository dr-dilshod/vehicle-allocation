<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_prices', function (Blueprint $table) {
            $table->bigIncrements('price_id');
            $table->unsignedBigInteger('shipper_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('driver_id');
            $table->tinyInteger('type');
            $table->unsignedBigInteger('price');
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id')->nullable();
            $table->unsignedBigInteger('update_id')->nullable();
            $table->timestamps();

            $table->index(['create_id', 'update_id']);
            $table->foreign('create_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('update_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_prices');
    }
}
