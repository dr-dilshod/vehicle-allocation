<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUnitPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_prices', function (Blueprint $table) {
            $table->string('car_type', 10)->after('price');
            $table->string('shipper_no', 4)->after('car_type');
            $table->string('stack_point', 60)->after('shipper_no')->nullable();
            $table->string('down_point', 60)->after('stack_point')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_prices', function (Blueprint $table) {
            //
        });
    }
}
