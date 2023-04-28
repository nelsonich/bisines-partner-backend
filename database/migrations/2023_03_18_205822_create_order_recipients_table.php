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
    Schema::create('order_recipients', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('order_id');

      // Customer info
      $table->string('full_name');
      $table->string('phone');

      // Address
      $table->uuid('city_id');
      $table->double('shipping_cost');
      $table->string('address');
      $table->string('house')->nullable();
      $table->string('access')->nullable();
      $table->string('floor')->nullable();
      $table->string('intercom')->nullable();

      // Date time
      $table->date('date');
      $table->string('time');
      $table->timestamps();

      $table
        ->foreign('order_id')
        ->references('id')
        ->on('orders')
        ->onDelete('cascade');

      $table
        ->foreign('city_id')
        ->references('id')
        ->on('shipping_cities')
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
    Schema::dropIfExists('order_recipients');
  }
};
