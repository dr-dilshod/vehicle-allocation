<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->bigIncrements('dispatch_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('item_id');
            $table->tinyInteger('timezone');
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
        Schema::dropIfExists('dispatch_board');
    }
}
