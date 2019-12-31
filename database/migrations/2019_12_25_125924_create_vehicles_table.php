<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('subcontract_id');
            $table->string('subcontract_no',4);
            $table->string('company_name',60);
            $table->string('company_kana_name',60)->nullable();
            $table->string('subcontract_company_abbreviation',60)->nullable();
            $table->string('subcontract_postal_code',60)->nullable();
            $table->string('subcontract_address1',120)->nullable();
            $table->string('subcontract_address2',120)->nullable();
            $table->string('subcontract_phone_number',64)->nullable();
            $table->string('subcontract_fax_number',64)->nullable();
            $table->tinyInteger('offset')->default(0);
            $table->string('subcontract_remark')->nullable();
            $table->tinyInteger('delete_flg')->default(0);
            $table->bigInteger('create_id')->unsigned()->nullable();
            $table->bigInteger('update_id')->unsigned()->nullable();
            $table->timestamps();

            $table->index('create_id');
            $table->index('update_id');
            $table->foreign('create_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('update_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
