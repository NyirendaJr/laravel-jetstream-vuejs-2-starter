<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeOfItemCountColumnFromBigintToDecimalFromProductPurchaseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('product_purchase', function (Blueprint $table) {
      $table->decimal('item_count', 8, 4)->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('product_purchase', function (Blueprint $table) {
      //
    });
  }
}
