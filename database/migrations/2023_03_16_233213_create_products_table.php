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
    Schema::create('products', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('category_id');
      $table->double('price');
      $table->string('image_key')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table
        ->foreign('category_id')
        ->references('id')
        ->on('categories')
        ->onDelete('cascade');
    });

    Schema::table('products', function (Blueprint $table) {
      $table->dropPrimary();
    });

    Schema::table('products', function (Blueprint $table) {
      $table
        ->integer('code')
        ->unsigned()
        ->unique()
        ->after('category_id')
        ->autoIncrement()
        ->startingValue(135101);
    });

    Schema::table('products', function (Blueprint $table) {
      $table->dropPrimary();
    });

    Schema::table('products', function (Blueprint $table) {
      $table->primary(['id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
  }
};
