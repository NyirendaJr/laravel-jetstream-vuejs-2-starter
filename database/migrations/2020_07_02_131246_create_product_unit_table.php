<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUnitTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_unit', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('unit_id')->unsigned();
      $table->decimal('buying_price');
      $table->decimal('selling_price');
      $table->bigInteger('product_id')->unsigned();
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
    Schema::dropIfExists('product_units');
  }
}
