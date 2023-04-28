<?php

namespace App\Http\Controllers;

use App\Models\Shipping\ShippingCity;
use Illuminate\Http\Request;

class ShippingCitiesController extends Controller
{
  /**
   * GET: /api/citys
   */
  public function getMany()
  {
    $shippingCities = ShippingCity::query()
      ->with('translations')
      ->get();

    $mapped = [];
    foreach ($shippingCities as $shippingCity) {
      $item = [
        'id' => $shippingCity->id,
        'cost' => $shippingCity->cost,
        'translations' => [],
      ];

      foreach ($shippingCity->translations as $translation) {
        $item['translations'][$translation->language->locale] =
          $translation->name;
      }

      $mapped[] = $item;
    }

    return response()->json([
      'shipping_cities' => $mapped,
      'status' => 'success',
    ]);
  }
}
