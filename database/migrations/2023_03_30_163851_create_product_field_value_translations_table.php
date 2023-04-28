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
    Schema::create('product_field_value_translations', function (
      Blueprint $table
    ) {
      $table->uuid('id')->primary();
      $table->uuid('product_field_value_id');
      $table->uuid('language_id');
      $table->string('title');
      $table->timestamps();

      $table
        ->foreign('product_field_value_id')
        ->references('id')
        ->on('product_field_values')
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
    Schema::dropIfExists('product_field_value_translations');
  }
};
