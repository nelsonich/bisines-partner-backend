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
    Schema::create('product_detail_value_translations', function (
      Blueprint $table
    ) {
      $table->uuid('id')->primary();
      $table->uuid('language_id');
      $table->uuid('product_detail_val_id');
      $table->string('title');
      $table->timestamps();

      $table
        ->foreign('language_id')
        ->references('id')
        ->on('languages')
        ->onDelete('cascade');

      $table
        ->foreign('product_detail_val_id')
        ->references('id')
        ->on('product_detail_values')
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
    Schema::dropIfExists('product_detail_value_translations');
  }
};
