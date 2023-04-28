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
    Schema::create('category_translations', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('category_id');
      $table->uuid('language_id');
      $table->string('title');
      $table->timestamps();

      $table
        ->foreign('category_id')
        ->references('id')
        ->on('categories')
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
    Schema::dropIfExists('category_translations');
  }
};
