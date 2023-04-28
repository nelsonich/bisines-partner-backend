<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductField;
use App\Models\Product\ProductFieldValue;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  /**
   * GET: /api/products
   */
  public function productList(Request $request)
  {
    $productsQuery = Product::query()
      ->limit($request->limit ?? 20)
      ->offset($request->offset ?? 0)
      ->with([
        'translations',
        'category' => function ($query) {
          return $query->with('translations');
        },
      ]);

    $filter = json_decode($request->filter ?? '{}');

    $category = null;
    if (isset($filter->categoryKey)) {
      $category = Category::query()
        ->where('key', $filter->categoryKey)
        ->first();

      $productsQuery->where('category_id', $category->id);
      unset($filter->categoryKey);
    }

    $knownFieldsAndValues = [];
    foreach ($filter as $filterKey => $filterValues) {
      if (!is_array($filterValues)) {
        $filterValues = [$filterValues];
      }

      if (empty($filterValues)) {
        continue;
      }

      if ($filterKey === 'minPrice') {
        $productsQuery->where('price', '>=', $filterValues[0]);
        continue;
      } elseif ($filterKey === 'maxPrice') {
        $productsQuery->where('price', '<=', $filterValues[0]);
        continue;
      }

      $cacheKeyField = $category->id . '/' . $filterKey;
      if (!isset($knownFieldsAndValues[$cacheKeyField])) {
        $knownFieldsAndValues[$cacheKeyField] = ProductField::query()
          ->where('category_id', $category->id)
          ->whereIn('type', [
            ProductField::TYPE_GROUP,
            ProductField::TYPE_SINGLE,
          ])
          ->where('key', $filterKey)
          ->first();
      }
      $productFieldId = $knownFieldsAndValues[$cacheKeyField]->id;

      $productFieldValueIds = [];
      foreach ($filterValues as $filterValue) {
        $cacheKeyValue = $category->id . '/' . $filterKey . '/' . $filterValue;
        if (!isset($knownFieldsAndValues[$cacheKeyValue])) {
          $knownFieldsAndValues[$cacheKeyValue] = ProductFieldValue::query()
            ->where(
              'product_field_id',
              $knownFieldsAndValues[$cacheKeyField]->id
            )
            ->where('id', $filterValue)
            ->first();
        }
        $productFieldValueIds[] = $knownFieldsAndValues[$cacheKeyValue]->id;
      }

      $productsQuery->whereHas('detail', function ($query) use (
        $productFieldId,
        $productFieldValueIds
      ) {
        $query
          ->where('product_field_id', $productFieldId)
          ->whereHas('value', function ($query) use ($productFieldValueIds) {
            $query->whereIn('product_field_value_id', $productFieldValueIds);
          });
      });
    }

    $products = $productsQuery->get();

    $mapped = [];
    foreach ($products as $product) {
      $item = [
        'id' => $product->id,
        'image_key' => $product->image_key,
        'code' => $product->code,
        'price' => $product->price,
        'category' => [
          'key' => $product->category->key,
          'translations' => [],
        ],
        'translations' => [],
      ];

      foreach ($product->translations as $translation) {
        $arr = [
          'slug' => $translation->slug,
          'title' => $translation->title,
        ];
        $item['translations'][$translation->language->locale] = $arr;
      }

      foreach ($product->category->translations as $translation) {
        $item['category']['translations'][$translation->language->locale] =
          $translation->title;
      }

      $mapped[] = $item;
    }

    return response()->json([
      'products' => $mapped,
      'status' => 'success',
    ]);
  }

  /**
   * GET: /api/categories/{categoryKey}/products
   */
  public function products(Request $request, $categoryKey)
  {
    $category = Category::query()
      ->where('key', $categoryKey)
      ->first();

    $products = Product::query()
      ->with([
        'category' => function ($query) {
          return $query->with('translations');
        },
      ])
      ->where('category_id', $category->id)
      ->get();

    $mapped = [];
    foreach ($products as $product) {
      $item = [
        'id' => $product->id,
        'image_key' => $product->image_key,
        'code' => $product->code,
        'price' => $product->price,
        'category' => [
          'key' => $category->key,
          'translations' => [],
        ],
        'translations' => [],
      ];

      foreach ($product->translations as $translation) {
        $arr = [
          'slug' => $translation->slug,
          'title' => $translation->title,
        ];
        $item['translations'][$translation->language->locale] = $arr;
      }

      foreach ($product->category->translations as $translation) {
        $item['category']['translations'][$translation->language->locale] =
          $translation->title;
      }

      $mapped[] = $item;
    }

    return response()->json([
      'products' => $mapped,
      'status' => 'success',
    ]);
  }

  /**
   * GET: /api/categories/{categoryKey}/products/{productId}/other
   */
  public function otherProducts(Request $request, $categoryKey, $productId)
  {
    $category = Category::query()
      ->where('key', $categoryKey)
      ->first();

    $products = Product::query()
      ->with([
        'category' => function ($query) {
          return $query->with('translations');
        },
      ])
      ->where('category_id', $category->id)
      ->where('id', '!=', $productId)
      ->inRandomOrder()
      ->limit(10)
      ->get();

    $mapped = [];
    foreach ($products as $product) {
      $item = [
        'id' => $product->id,
        'image_key' => $product->image_key,
        'code' => $product->code,
        'price' => $product->price,
        'category' => [
          'key' => $category->key,
          'translations' => [],
        ],
        'translations' => [],
      ];

      foreach ($product->translations as $translation) {
        $arr = [
          'slug' => $translation->slug,
          'title' => $translation->title,
        ];
        $item['translations'][$translation->language->locale] = $arr;
      }

      foreach ($product->category->translations as $translation) {
        $item['category']['translations'][$translation->language->locale] =
          $translation->title;
      }

      $mapped[] = $item;
    }

    return response()->json([
      'other_products' => $mapped,
      'status' => 'success',
    ]);
  }

  /**
   * GET: /api/categories/{categoryKey}/products/{productId}
   */
  public function product(Request $request, $categoryKey, $productId)
  {
    $product = Product::query()
      ->with(['translations', 'images'])
      ->whereId($productId)
      ->first();

    $response = [
      'id' => $product->id,
      'code' => $product->code,
      'price' => $product->price,
      'translations' => [],
      'images' => [],
    ];

    foreach ($product->translations as $translation) {
      $arr = [
        'title' => $translation->title,
        'description' => $translation->description,
        'slug' => $translation->slug,
      ];

      $response['translations'][$translation->language->locale] = $arr;
    }

    $imageList = [];
    foreach ($product->images as $image) {
      $imageList = [
        'original' => $image->image_key,
        'thumbnail' => $image->image_key,
      ];
      $response['images'][] = $imageList;
    }

    return response()->json([
      'product' => $response,
      'status' => 'success',
    ]);
  }
}
