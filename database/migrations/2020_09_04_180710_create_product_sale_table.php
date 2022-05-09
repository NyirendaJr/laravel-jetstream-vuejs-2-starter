<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSaleTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_sale', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('sale_id')->unsigned();
      $table->bigInteger('product_id')->unsigned();
      $table->decimal('qty');
      $table->decimal('price');
      $table->decimal('total');
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
    Schema::dropIfExists('product_sale');
  }
}
