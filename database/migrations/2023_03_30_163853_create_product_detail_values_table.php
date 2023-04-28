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
    Schema::create('product_detail_values', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('product_id');
      $table->uuid('product_detail_id');
      $table->uuid('product_field_id');
      $table->uuid('product_field_value_id')->nullable();
      $table->timestamps();

      $table
        ->foreign('product_id')
        ->references('id')
        ->on('products')
        ->onDelete('cascade');

      $table
        ->foreign('product_detail_id')
        ->references('id')
        ->on('product_details')
        ->onDelete('cascade');

      $table
        ->foreign('product_field_id')
        ->references('id')
        ->on('product_fields')
        ->onDelete('cascade');

      $table
        ->foreign('product_field_value_id')
        ->references('id')
        ->on('product_field_values')
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
    Schema::dropIfExists('product_detail_values');
  }
};
