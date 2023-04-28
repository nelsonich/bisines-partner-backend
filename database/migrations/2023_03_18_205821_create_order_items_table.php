<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('order_items', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('order_id');
      $table->uuid('product_id');
      $table->smallInteger('quantity');
      $table->double('price');
      $table->double('total');
      $table->timestamps();

      $table
        ->foreign('order_id')
        ->references('id')
        ->on('orders')
        ->onDelete('cascade');

      $table
        ->foreign('product_id')
        ->references('id')
        ->on('products')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('order_items');
  }
};
