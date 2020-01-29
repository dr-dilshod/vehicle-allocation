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
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->tinyInteger('type');
            $table->unsignedBigInteger('price');
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id')->nullable();
            $table->unsignedBigInteger('update_id')->nullable();
            $table->timestamps();

            $table->index(['create_id', 'update_id', 'shipper_id', /*'item_id', 'driver_id'*/], 'unit_prices-default-indexes');
            $table->foreign('create_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('update_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('shipper_id')->references('shipper_id')->on('shippers')->onDelete('restrict')->onUpdate('restrict');
//            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('restrict')->onUpdate('restrict');
//            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');
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
