<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product\Product;
use App\Models\Product\ProductDetail;
use App\Models\Product\ProductDetailValue;
use App\Models\Product\ProductField;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
  private function cleanupTranslations($productId)
  {
    ProductTranslation::query()
      ->where('product_id', $productId)
      ->delete();
  }

  private function createTranslations($title, $description, $productId)
  {
    $languages = Language::all();

    foreach ($languages as $language) {
      ProductTranslation::create([
        'product_id' => $productId,
        'language_id' => $language->id,
        'title' => $title[$language->locale],
        'description' => $description[$language->locale],
      ]);
    }
  }

  private function createProductDetails($productFields, $productId, $categoryId)
  {
    $fields = ProductField::query()
      ->where('category_id', $categoryId)
      ->get();

    foreach ($fields as $field) {
      $productDetail = ProductDetail::create([
        'product_id' => $productId,
        'product_field_id' => $field->id,
      ]);

      if ($field->type === ProductField::TYPE_GROUP) {
        foreach ($productFields[$field->key] as $productFieldValue) {
          ProductDetailValue::create([
            'product_id' => $productId,
            'product_detail_id' => $productDetail->id,
            'product_field_id' => $field->id,
            'product_field_value_id' => $productFieldValue,
          ]);
        }
      }

      if ($field->type === ProductField::TYPE_SINGLE) {
        ProductDetailValue::create([
          'product_id' => $productId,
          'product_detail_id' => $productDetail->id,
          'product_field_id' => $field->id,
          'product_field_value_id' => $productFields[$field->key],
        ]);
      }
    }
  }

  /**
   * GET: /api/admin/products
   */
  public function getMany()
  {
    $products = Product::query()
      ->with([
        'category',
        'translations' => function ($query) {
          $query->with('language');
        },
      ])
      ->orderBy('id', 'desc')
      ->get();

    $mapped = [];
    foreach ($products as $product) {
      $item = [
        'id' => $product->id,
        'image_key' => $product->image_key,
        'price' => $product->price,
        'translations' => [],
        'category' => [
          'key' => $product->category->key,
          'translations' => [],
        ],
      ];

      foreach ($product->translations as $translation) {
        $item['translations'][$translation->language->locale] =
          $translation->title;
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
   * GET: /api/admin/products/{id}
   */
  public function getOne(Request $request, $id)
  {
    $product = Product::query()
      ->with([
        'detail',
        'category',
        'translations' => function ($query) {
          $query->with('language');
        },
      ])
      ->whereId($id)
      ->first();

    $item = [
      'id' => $product->id,
      'image_key' => $product->image_key,
      'price' => $product->price,
      'translations' => [],
      'category' => [
        'id' => $product->category->id,
        'key' => $product->category->key,
        'translations' => [],
      ],
      'details' => [],
    ];

    foreach ($product->translations as $translation) {
      $arr = [
        'title' => $translation->title,
        'description' => $translation->description,
      ];
      $item['translations'][$translation->language->locale] = $arr;
    }

    foreach ($product->category->translations as $translation) {
      $item['category']['translations'][$translation->language->locale] =
        $translation->title;
    }

    return response()->json([
      'product' => $item,
      '_product' => $product,
      'status' => 'success',
    ]);
  }

  /**
   * POST: /api/admin/products
   */
  public function create(Request $request)
  {
    $category = $request->post('category');
    $price = $request->post('price');
    $title = $request->post('title');
    $description = $request->post('description');
    $productFields = $request->post('productFields');
    $productImages = $request->post('images');

    $product = Product::create([
      'category_id' => $category,
      'price' => $price,
      'image_key' => $productImages[0],
    ]);

    $this->createTranslations($title, $description, $product->id);
    $this->createProductDetails($productFields, $product->id, $category);

    array_shift($productImages);

    if (count($productImages)) {
      foreach ($productImages as $image) {
        ProductImage::create([
          'product_id' => $product->id,
          'image_key' => $image,
        ]);
      }
    }

    return response()->json([
      'product' => $product,
      'status' => 'success',
    ]);
  }

  /**
   * PUT: /api/admin/products/{id}
   */
  public function edit(Request $request, $id)
  {
    // $category = $request->post('category');
    $price = $request->post('price');
    $title = $request->post('title');
    $description = $request->post('description');
    // $productFields = $request->post('productFields');

    $product = Product::find($id);
    $product->price = $price;
    $product->save();

    $this->cleanupTranslations($product->id);
    $this->createTranslations($title, $description, $product->id);
    // $this->createProductDetails($productFields, $product->id, $category);

    // $productImages = [
    //   [
    //     'id' => (string) Str::uuid(),
    //     'product_id' => $product->id,
    //     'image_key' =>
    //     'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
    //   ],
    //   [
    //     'id' => (string) Str::uuid(),
    //     'product_id' => $product->id,
    //     'image_key' =>
    //     'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
    //   ],
    //   [
    //     'id' => (string) Str::uuid(),
    //     'product_id' => $product->id,
    //     'image_key' =>
    //     'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
    //   ],
    // ];

    // ProductImage::insert($productImages);

    return response()->json([
      'product' => $product,
      'status' => 'success',
    ]);
  }

  /**
   * DELETE: /api/admin/products/{id}
   */
  public function delete(Request $request, $id)
  {
    Product::destroy($id);

    return response()->json([
      'status' => 'success',
    ]);
  }
}
