<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CheckoutRequest;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderRecipient;
use App\Models\Shipping\ShippingCity;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  private function validateTotalPrice($total, $shoppingCart, $city)
  {
    $shipping = ShippingCity::find($city);
    $localTotal = 0;
    foreach ($shoppingCart as $item) {
      $localTotal += $item->quantity * $item->product->price;
    }

    $localTotal += $shipping->cost;

    if ((int) $localTotal !== (int) $total) {
      return false;
    }

    return true;
  }

  private function createOrderItems($orderId, $shoppingCart)
  {
    foreach ($shoppingCart as $item) {
      OrderItem::create([
        'order_id' => $orderId,
        'product_id' => $item->product_id,
        'quantity' => $item->quantity,
        'price' => $item->product->price,
        'total' => $item->quantity * $item->product->price,
      ]);
    }
  }

  private function createOrderRecipient(Request $request, $orderId)
  {
    $fullName = $request->post('fullName');
    $phone = $request->post('phone');
    $city = $request->post('city');
    $address = $request->post('address');
    $house = $request->post('house');
    $access = $request->post('access');
    $floor = $request->post('floor');
    $intercom = $request->post('intercom');
    $date = $request->post('date');
    $time = $request->post('time');

    $shipping = ShippingCity::find($city);

    OrderRecipient::create([
      'order_id' => $orderId,
      'full_name' => $fullName,
      'phone' => $phone,
      'city_id' => $city,
      'shipping_cost' => $shipping->cost,
      'address' => $address,
      'house' => $house,
      'access' => $access,
      'floor' => $floor,
      'intercom' => $intercom,
      'date' => $date,
      'time' => $time,
    ]);
  }

  private function emptyShoppingCart()
  {
    ShoppingCart::query()
      ->where('user_id', auth()->id())
      ->delete();
  }

  /**
   * GET: /api/orders
   */
  public function getOrders()
  {
    $orders = Order::query()
      ->with([
        'recipient' => function ($query) {
          return $query->with([
            'city' => function ($query) {
              return $query->with('translations');
            },
          ]);
        },
        'items' => function ($query) {
          return $query->with([
            'product' => function ($query) {
              return $query->with('translations');
            },
          ]);
        },
      ])
      ->where('user_id', auth()->id())
      ->get();

    $mapped = [];
    foreach ($orders as $order) {
      $orderInfo = [
        'code' => $order->code,
        'total' => $order->total,
        'status' => $order->status,
        'comment' => $order->comment,
        'payment_type' => $order->payment_type,
        'recipient' => [
          'full_name' => $order->recipient->full_name,
          'phone' => $order->recipient->phone,
          'address' => $order->recipient->address,
          'house' => $order->recipient->house,
          'access' => $order->recipient->access,
          'floor' => $order->recipient->floor,
          'intercom' => $order->recipient->intercom,
          'shipping_cost' => $order->recipient->shipping_cost,
          'city' => [],
        ],
        'items' => [],
      ];

      foreach ($order->items as $item) {
        $itemInfo = [
          'quantity' => $item->quantity,
          'price' => $item->price,
          'total' => $item->total,
          'product' => [
            'code' => $item->product->code,
            'image_key' => $item->product->image_key,
            'translations' => [],
          ],
        ];

        foreach ($item->product->translations as $translation) {
          $itemInfo['product']['translations'][$translation->language->locale] =
            $translation->title;
        }

        $orderInfo['items'][] = $itemInfo;
      }

      foreach ($order->recipient->city->translations as $translation) {
        $orderInfo['recipient']['city'][$translation->language->locale] =
          $translation->name;
      }

      $mapped[] = $orderInfo;
    }

    return response()->json([
      'orders' => $mapped,
      'status' => 'success',
    ]);
  }

  /**
   * POST: /api/orders
   */
  public function checkout(CheckoutRequest $request)
  {
    $total = $request->post('total');
    $comment = $request->post('comment');

    $shoppingCart = ShoppingCart::query()
      ->with('product')
      ->where('user_id', auth()->id())
      ->get();

    $validation = $this->validateTotalPrice(
      $total,
      $shoppingCart,
      $request->post('city')
    );

    if (!$validation) {
      return response()->json([
        'message' => 'Invalid total cost!',
        'status' => 'failed',
      ]);
    }

    $order = Order::create([
      'user_id' => auth()->id(),
      'total' => $total,
      'comment' => $comment,
    ]);

    $this->createOrderItems($order->id, $shoppingCart);
    $this->createOrderRecipient($request, $order->id);
    $this->emptyShoppingCart();

    return response()->json([
      'status' => 'success',
    ]);
  }
}
