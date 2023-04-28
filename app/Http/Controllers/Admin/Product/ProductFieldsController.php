<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductField;
use Illuminate\Http\Request;

class ProductFieldsController extends Controller
{
  /**
   * GET: /api/admin/product-fields/{categoryId}
   */
  public function getMany(Request $request, $categoryId)
  {
    $productFields = ProductField::query()
      ->with([
        'values' => function ($query) {
          return $query->with('translations');
        },
        'translations',
      ])
      ->where('category_id', $categoryId)
      ->get();

    $mapped = [];
    foreach ($productFields as $productField) {
      $item = [
        'id' => $productField->id,
        'key' => $productField->key,
        'type' => $productField->type,
        'translations' => [],
        'values' => [],
      ];

      foreach ($productField->translations as $translation) {
        $item['translations'][$translation->language->locale] =
          $translation->title;
      }

      foreach ($productField->values as $value) {
        $translations = [];
        foreach ($value->translations as $translation) {
          $translations[$translation->language->locale] = $translation->title;
        }

        $item['values'][] = [
          'id' => $value->id,
          'key' => $value->key,
          'translations' => $translations,
        ];
      }

      $mapped[] = $item;
    }

    return response()->json([
      'product_fields' => $mapped,
      'mapped' => $mapped,
      'status' => 'success',
    ]);
  }
}
