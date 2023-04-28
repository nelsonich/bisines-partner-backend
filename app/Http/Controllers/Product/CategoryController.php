<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductField;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * GET: /api/categories
   */
  public function categories(Request $request)
  {
    return $this->cachable($request, 120, function () {
      $categories = Category::query()
        ->with([
          'translations' => function ($query) {
            $query->with('language');
          },
        ])
        ->get();

      $mapped = [];
      foreach ($categories as $category) {
        $item = [
          'id' => $category->id,
          'image_key' => $category->image_key,
          'key' => $category->key,
          'translations' => [],
        ];

        foreach ($category->translations as $translation) {
          $item['translations'][$translation->language->locale] =
            $translation->title;
        }

        $mapped[] = $item;
      }

      return [
        'categories' => $mapped,
      ];
    });
  }

  /**
   * GET: /api/categories/{categoryKey}/product-fields
   */
  public function categoryProductFields(Request $request, $categoryKey)
  {
    $category = Category::query()
      ->where('key', $categoryKey)
      ->first();

    if (is_null($category)) {
      return response()->json(
        [
          'status' => 'failed',
          'resource' => 'Category',
        ],
        404
      );
    }

    $productFields = ProductField::query()
      ->where('category_id', $category->id)
      ->with([
        'translations',
        'values' => function ($query) {
          return $query->with('translations');
        },
      ])
      ->get();

    $response = [];
    foreach ($productFields as $productField) {
      $arr = [
        'id' => $productField->id,
        'key' => $productField->key,
        'type' => $productField->type,
        'translations' => [],
        'values' => [],
      ];

      foreach ($productField->translations as $translation) {
        $arr['translations'][$translation->language->locale] =
          $translation->title;
      }

      foreach ($productField->values as $value) {
        $valuesArr = [
          'id' => $value->id,
          'key' => $value->key,
          'translations' => [],
        ];

        foreach ($value->translations as $translation) {
          $valuesArr['translations'][$translation->language->locale] =
            $translation->title;
        }

        $arr['values'][] = $valuesArr;
      }

      $response[] = $arr;
    }

    return response()->json([
      'productFields' => $response,
      'status' => 'success',
    ]);
  }
}
