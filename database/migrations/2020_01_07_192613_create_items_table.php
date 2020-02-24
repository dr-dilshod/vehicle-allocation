<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateItemsTable
 * @author Dilshod K
 */
class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->unsignedBigInteger('shipper_id')->default(0);
            $table->unsignedBigInteger('driver_id')->default(0)->nullable();
            $table->unsignedBigInteger('vehicle_id')->default(0)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->date('stack_date');
            $table->time('stack_time');
            $table->date('down_date');
            $table->time('down_time');
            $table->tinyInteger('down_invoice')->default(0)->nullable();
            $table->string('stack_point', 60)->default(null);
            $table->string('down_point', 60)->default(null);
            $table->integer('weight')->nullable();
            $table->tinyInteger('empty_pl')->default(0)->nullable();
            $table->integer('item_price')->nullable();
            $table->string('item_driver_name', 60)->nullable();
            $table->string('vehicle_no3', 4)->nullable();
            $table->string('shipper_name', 60)->nullable();
            $table->string('item_vehicle', 60)->nullable();
            $table->integer('vehicle_payment')->nullable();
            $table->date('item_completion_date')->nullable();
            $table->string('item_remark', 255)->nullable();
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id')->unsigned()->nullable();
            $table->unsignedBigInteger('update_id')->unsigned()->nullable();
            $table->timestamps();
            $table->index(['create_id', 'update_id', 'shipper_id'], 'items-driver-shipper-default-indexes');
            $table->foreign('create_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('update_id')->references('driver_id')->on('drivers')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('shipper_id')->references('shipper_id')->on('shippers')->onDelete('restrict')->onUpdate('restrict');

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
