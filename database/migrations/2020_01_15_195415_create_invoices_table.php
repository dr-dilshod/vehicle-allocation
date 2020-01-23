<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('invoice_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('shipper_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->dateTime('billing_recording_date')->nullable();
            $table->dateTime('billing_deadline_date')->nullable();
            $table->dateTime('payment_record_date')->nullable();
            $table->string('invoice_remark', 255)->nullable();
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id');
            $table->unsignedBigInteger('update_id');
            $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
