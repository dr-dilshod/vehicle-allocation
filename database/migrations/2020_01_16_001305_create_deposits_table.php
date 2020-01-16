<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('deposit_id');
            $table->unsignedBigInteger('invoice_id');
            $table->integer('deposit_amount')->default(0);
            $table->integer('fee')->default(0);
            $table->string('deposit_remark', 255)->nullable();
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
        Schema::dropIfExists('deposit');
    }
}
