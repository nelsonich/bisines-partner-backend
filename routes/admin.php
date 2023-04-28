<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductFieldsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\UsersController;

// use App\Http\Controllers\Admin\ProductController;
// use App\Http\Controllers\Admin\ReviewController;

Route::group(
  [
    'prefix' => '/admin',
    'middleware' => MIDDLEWARE_GROUP_AUTH,
  ],
  function () {
    Route::get('/check', [LoginController::class, 'check']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::post('/login', [LoginController::class, 'login'])->withoutMiddleware(
      MIDDLEWARE_GROUP_AUTH
    );

    // Users
    Route::group(['prefix' => '/users'], function () {
      Route::get('/', [UsersController::class, 'getMany']);
    });

    // Products
    Route::group(['prefix' => '/products'], function () {
      Route::get('/', [ProductController::class, 'getMany']);
      Route::get('/{id}', [ProductController::class, 'getOne']);
      Route::post('/', [ProductController::class, 'create']);
      Route::put('/{id}', [ProductController::class, 'edit']);
      Route::delete('/{id}', [ProductController::class, 'delete']);
    });

    // Products fields
    Route::group(['prefix' => '/product-fields/{categoryId}'], function () {
      Route::get('/', [ProductFieldsController::class, 'getMany']);
    });

    // Reviews
    Route::group(['prefix' => '/reviews'], function () {
      Route::get('/', [ReviewsController::class, 'getMany']);
      Route::post('/', [ReviewsController::class, 'create']);
      Route::delete('/{id}', [ReviewsController::class, 'delete']);
    });

    // Orders
    Route::group(['prefix' => '/orders'], function () {
      Route::get('/', [OrderController::class, 'getMany']);
      Route::get('/{id}', [OrderController::class, 'getOne']);
    });
  }
);
