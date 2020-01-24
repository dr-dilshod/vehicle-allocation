<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippers', function (Blueprint $table) {
            $table->bigIncrements('shipper_id');
            $table->string('shipper_no');
            $table->string('shipper_name1');
            $table->string('shipper_name2')->nullable();
            $table->string('shipper_kana_name1')->nullable();
            $table->string('shipper_kana_name2')->nullable();
            $table->string('shipper_company_abbreviation')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->tinyInteger('closing_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->tinyInteger('delete_flg')->default(0);
            $table->unsignedBigInteger('create_id')->nullable();
            $table->unsignedBigInteger('update_id')->nullable();
            $table->timestamps();
            $table->foreign('create_id')->references('driver_id')->on('drivers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('update_id')->references('driver_id')->on('drivers')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shippers');
    }
}
