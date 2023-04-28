<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  /**
   * GET: /api/admin/orders
   */
  public function getMany()
  {
    $orders = Order::query()
      ->orderBy('id', 'desc')
      ->get();

    $mapped = [];
    foreach ($orders as $order) {
      $item = [
        'id' => $order->id,
        'code' => $order->code,
        'total' => $order->total,
        'status' => $order->status,
        'comment' => $order->comment,
        'payment_type' => $order->payment_type,
      ];

      $mapped[] = $item;
    }

    return response()->json([
      'orders' => $mapped,
      'status' => 'success',
    ]);
  }

  /**
   * GET: /api/admin/orders/{id}
   */
  public function getOne(Request $request, $id)
  {
    $order = Order::query()
      ->with(['recipient', 'items'])
      ->whereId($id)
      ->first();

    $order = Order::query()
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
      ->whereId($id)
      ->first();

    if (is_null($order)) {
      return response()->json([
        'message' => 'Order not found!',
        'status' => 'failed',
      ]);
    }

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
        'date' => $order->recipient->date,
        'time' => $order->recipient->time,
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

    return response()->json([
      'order' => $orderInfo,
      'status' => 'success',
    ]);
  }
}
