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
    Schema::create('shipping_city_translations', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('shipping_city_id');
      $table->uuid('language_id');
      $table->string('name');
      $table->timestamps();

      $table
        ->foreign('shipping_city_id')
        ->references('id')
        ->on('shipping_cities')
        ->onDelete('cascade');

      $table
        ->foreign('language_id')
        ->references('id')
        ->on('languages')
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
    Schema::dropIfExists('shipping_city_translations');
  }
};
