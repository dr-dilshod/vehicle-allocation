<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DepositsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->index(['invoice_id', 'create_id', 'update_id']);
            $table->foreign('invoice_id')
                ->references('invoice_id')
                ->on('invoices')
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
