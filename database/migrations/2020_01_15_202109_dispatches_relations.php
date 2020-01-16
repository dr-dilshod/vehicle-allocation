<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DispatchesRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispatches', function (Blueprint $table) {
            $table->index(['driver_id', 'item_id', 'create_id', 'update_id']);
            $table->foreign('driver_id')
                ->references('driver_id')
                ->on('drivers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('item_id')
                ->references('item_id')
                ->on('items')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('create_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('update_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
