<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropProductSaleUnitForeignFromProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sale', function (Blueprint $table) {
//            $table->renameColumn('product_unit_id', 'unit_id');
            $table->dropForeign('product_sale_unit_foreign');
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
