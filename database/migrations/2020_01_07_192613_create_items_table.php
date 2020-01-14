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

            $table->bigInteger('shipper_id')->default(0);
            $table->bigInteger('driver_id')->default(0);
            $table->string('vehicle_no',4)->default(null);
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
            $table->tinyInteger('delete_flg')->default(0)->nullable();
            $table->bigInteger('create_id')->unsigned()->nullable();
            $table->bigInteger('update_id')->unsigned()->nullable();
            $table->timestamps();
            $table->index('create_id');
            $table->index('update_id');
            $table->foreign('create_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('update_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');

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
