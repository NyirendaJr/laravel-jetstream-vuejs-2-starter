<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnUnitIdToProductUnitIdInProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sale', function (Blueprint $table) {
            $table->renameColumn('unit_id', 'product_unit_id');
            $table->foreign('product_unit_id')->references('id')->on('product_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_sale', function (Blueprint $table) {
            //
        });
    }
}
