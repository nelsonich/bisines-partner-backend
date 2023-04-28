<?php

use App\Models\Product\ProductField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  private $types = [
    ProductField::TYPE_INPUT,
    ProductField::TYPE_GROUP,
    ProductField::TYPE_SINGLE,
  ];

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_fields', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('category_id');
      $table->string('key');
      $table->enum('type', $this->types);
      $table->timestamps();

      $table
        ->foreign('category_id')
        ->references('id')
        ->on('categories')
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
    Schema::dropIfExists('product_fields');
  }
};
