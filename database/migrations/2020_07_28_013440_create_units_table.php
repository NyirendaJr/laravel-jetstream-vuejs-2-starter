<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('units', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->integer('count');
      $table->bigInteger('store_id')->unsigned();
      $table->foreign('store_id')->references('id')->on('stores')
        ->onDelete('CASCADE');
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
    Schema::dropIfExists('units');
  }
}
