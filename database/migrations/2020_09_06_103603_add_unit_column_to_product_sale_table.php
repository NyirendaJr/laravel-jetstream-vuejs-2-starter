<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitColumnToProductSaleTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('product_sale', function (Blueprint $table) {
      $table->bigInteger('unit')->unsigned();
      $table->foreign('unit')->references('id')->on('units');
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
