<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
  /**
   * GET: /api/shopping-cart
   */
  public function getProducts()
  {
    $total = 0;
    $shoppingCart = ShoppingCart::query()
      ->with([
        'product' => function ($query) {
          return $query->with(['category', 'translations']);
        },
      ])
      ->where('user_id', auth()->id())
      ->get();

    $mapped = [];
    foreach ($shoppingCart as $item) {
      $product = [
        'quantity' => $item->quantity,
        'cart_item_id' => $item->id,
        'id' => $item->product->id,
        'image_key' => $item->product->image_key,
        'code' => $item->product->code,
        'price' => $item->product->price,
        'translations' => [],
        'category' => [
          'key' => $item->product->category->key,
        ],
      ];

      foreach ($item->product->translations as $translation) {
        $arr = [
          'title' => $translation->title,
          'slug' => $translation->slug,
        ];
        $product['translations'][$translation->language->locale] = $arr;
      }

      $mapped[] = $product;
      $total += $item->quantity * $item->product->price;
    }

    return response()->json([
      'products' => $mapped,
      'total' => $total,
      'status' => 'success',
    ]);
  }

  /**
   * POST: /api/shopping-cart
   */
  public function addToCart(Request $request)
  {
    $userId = auth()->id();
    $productId = $request->post('productId');
    $quantity = $request->post('quantity');

    $shoppingCart = ShoppingCart::query()
      ->where('user_id', $userId)
      ->where('product_id', $productId)
      ->first();

    if (is_null($shoppingCart)) {
      ShoppingCart::create([
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $quantity,
      ]);
    } else {
      $shoppingCart->increment('quantity', $quantity);
    }

    return response()->json([
      'status' => 'success',
    ]);
  }

  /**
   * DELETE: /api/shopping-cart/{id}
   */
  public function removeCartItem(Request $request, $id)
  {
    ShoppingCart::destroy($id);

    return response()->json([
      'status' => 'success',
    ]);
  }

  /**
   * PUT: /api/shopping-cart/{id}/increment
   */
  public function increment(Request $request, $id)
  {
    ShoppingCart::query()
      ->whereId($id)
      ->increment('quantity');

    return response()->json([
      'status' => 'success',
    ]);
  }

  /**
   * GET: /api/shopping-cart/{id}/decrement
   */
  public function decrement(Request $request, $id)
  {
    ShoppingCart::query()
      ->whereId($id)
      ->decrement('quantity');

    return response()->json([
      'status' => 'success',
    ]);
  }
}
