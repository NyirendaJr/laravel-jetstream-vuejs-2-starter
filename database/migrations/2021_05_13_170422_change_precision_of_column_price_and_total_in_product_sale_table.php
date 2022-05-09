<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePrecisionOfColumnPriceAndTotalInProductSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_sale', function (Blueprint $table) {
            $table->decimal('price',15, 2)->change();
            $table->decimal('total',15, 2)->change();
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
