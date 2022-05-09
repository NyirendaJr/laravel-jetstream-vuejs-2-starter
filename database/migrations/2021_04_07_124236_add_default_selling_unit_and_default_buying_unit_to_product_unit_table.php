<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultSellingUnitAndDefaultBuyingUnitToProductUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_unit', function (Blueprint $table) {
            $table->boolean('default_selling_unit')->default(0)->nullable();
            $table->boolean('default_buying_unit')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_unit', function (Blueprint $table) {
            //
        });
    }
}
