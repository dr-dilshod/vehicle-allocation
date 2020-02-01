<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->index(['shipper_id', 'create_id', 'update_id'], 'payments_default_indexes');
                $table->foreign('shipper_id')
                ->references('shipper_id')
                ->on('shippers')
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
