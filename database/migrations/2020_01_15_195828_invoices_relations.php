<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoicesRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->index(['item_id', 'shipper_id', 'vehicle_id', 'create_id', 'update_id']);
            $table->foreign('item_id')
                ->references('item_id')
                ->on('items')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('shipper_id')
                ->references('shipper_id')
                ->on('shippers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('vehicle_id')
                ->references('vehicle_id')
                ->on('vehicles')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('create_id')
                ->references('driver_id')
                ->on('drivers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('update_id')
                ->references('driver_id')
                ->on('drivers')
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
