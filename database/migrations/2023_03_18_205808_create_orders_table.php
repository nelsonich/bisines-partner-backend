<?php

use App\Models\Order\Order;
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
    Schema::create('orders', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id');
      $table->double('total');
      $table->enum('status', [Order::STATUSES])->default(Order::STATUS_PENDING);
      $table->text('comment')->nullable();
      $table
        ->enum('payment_type', Order::PAYMENT_TYPES)
        ->default(Order::PAYMENT_TYPE_CASH);
      $table->timestamps();

      $table
        ->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
    });

    Schema::table('orders', function (Blueprint $table) {
      $table->dropPrimary();
    });

    Schema::table('orders', function (Blueprint $table) {
      $table
        ->integer('code')
        ->unsigned()
        ->unique()
        ->after('user_id')
        ->autoIncrement()
        ->startingValue(135101);
    });

    Schema::table('orders', function (Blueprint $table) {
      $table->dropPrimary();
    });

    Schema::table('orders', function (Blueprint $table) {
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
    Schema::dropIfExists('orders');
  }
};
