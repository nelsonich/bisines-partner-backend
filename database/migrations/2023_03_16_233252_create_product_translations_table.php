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
    Schema::create('product_translations', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('product_id');
      $table->uuid('language_id');
      $table->string('title');
      $table->text('description');
      $table->string('slug');
      $table->timestamps();

      $table
        ->foreign('product_id')
        ->references('id')
        ->on('products')
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
    Schema::dropIfExists('product_translations');
  }
};
