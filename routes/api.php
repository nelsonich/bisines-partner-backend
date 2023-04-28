<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ShippingCitiesController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

if (!defined('MIDDLEWARE_GROUP_AUTH')) {
  define('MIDDLEWARE_GROUP_AUTH', ['auth:api']);
}

require_once __DIR__ . '/admin.php';

// Languages
// Route::group(['prefix' => '/languages'], function () {
//   Route::get('/', [LanguageController::class, 'getLanguages']);
// });

// Shipping cities
Route::group(['prefix' => '/shipping-cities'], function () {
  Route::get('/', [ShippingCitiesController::class, 'getMany']);
});

// Reviews
Route::group(['prefix' => '/reviews'], function () {
  Route::get('/', [ReviewsController::class, 'getMany']);
});

// Product list
Route::group(['prefix' => '/products'], function () {
  Route::get('/', [ProductController::class, 'productList']);
});

// Categories
Route::group(['prefix' => '/categories'], function () {
  Route::get('/', [CategoryController::class, 'categories']);
  Route::get('/{categoryKey}/product-fields', [
    CategoryController::class,
    'categoryProductFields',
  ]);

  // Products
  Route::group(['prefix' => '{categoryKey}/products'], function () {
    Route::get('/', [ProductController::class, 'products']);
    Route::get('/{productId}', [ProductController::class, 'product']);
    Route::get('/{productId}/other', [
      ProductController::class,
      'otherProducts',
    ]);
  });
});

Route::group(['prefix' => '/users'], function () {
  Route::post('/', [RegisterController::class, 'register']);

  Route::group(['prefix' => '/login'], function () {
    Route::get('/state', [LoginController::class, 'checkIsRegistered']);

    Route::post('/', [LoginController::class, 'login']);
    Route::post('/apple/{id}', [LoginController::class, 'appleLogin']);
    Route::post('/facebook/{id}', [LoginController::class, 'facebookLogin']);
    Route::post('/google/{id}', [LoginController::class, 'googleLogin']);
  });

  Route::post('/logout', [LoginController::class, 'logout'])->middleware(
    MIDDLEWARE_GROUP_AUTH
  );

  Route::group(['prefix' => '/password'], function () {
    Route::put('/', [ChangePasswordController::class, 'change'])->middleware(
      MIDDLEWARE_GROUP_AUTH
    );

    Route::group(['prefix' => '/recovery'], function () {
      Route::post('/', [PasswordResetController::class, 'create']);
      Route::get('/', [PasswordResetController::class, 'find']);
      Route::put('/', [PasswordResetController::class, 'reset']);
    });
  });

  Route::group(
    [
      'middleware' => MIDDLEWARE_GROUP_AUTH,
    ],
    function () {
      Route::get('/me', [UserController::class, 'getMe']);

      Route::group(['prefix' => '/profile'], function () {
        Route::put('/', [ProfileController::class, 'edit']);
        Route::patch('/', [ProfileController::class, 'update']);
      });
    }
  );
});

Route::group(
  [
    'middleware' => MIDDLEWARE_GROUP_AUTH,
  ],
  function () {
    // Shopping cart
    Route::group(['prefix' => '/shopping-cart'], function () {
      Route::get('/', [ShoppingCartController::class, 'getProducts']);
      Route::post('/', [ShoppingCartController::class, 'addToCart']);
      Route::delete('/{id}', [ShoppingCartController::class, 'removeCartItem']);
      Route::put('/{id}/increment', [
        ShoppingCartController::class,
        'increment',
      ]);
      Route::put('/{id}/decrement', [
        ShoppingCartController::class,
        'decrement',
      ]);
    });

    Route::group(['prefix' => '/orders'], function () {
      Route::get('/', [OrderController::class, 'getOrders']);
      Route::post('/', [OrderController::class, 'checkout']);
    });
  }
);
