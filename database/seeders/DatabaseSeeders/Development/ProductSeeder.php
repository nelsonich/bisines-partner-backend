<?php

namespace Database\Seeders\DatabaseSeeders\Development;

use App\Models\Category\Category;
use App\Models\Language;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductTranslation;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  private $categories = [];
  private $languages = [];

  private function getCategoryIdByKey($category)
  {
    if (!isset($this->categories[$category])) {
      $this->categories[$category] = Category::query()
        ->where('key', $category)
        ->first();
    }

    return $this->categories[$category]->id;
  }

  private function getLanguageIdByLocale($locale)
  {
    if (!isset($this->languages[$locale])) {
      $this->languages[$locale] = Language::query()
        ->where('locale', $locale)
        ->first();
    }

    return $this->languages[$locale]->id;
  }

  public function run()
  {
    foreach ($this->products as $productInfo) {
      $product = Product::create([
        'category_id' => $this->getCategoryIdByKey($productInfo['category']),
        'price' => $productInfo['price'],
        'image_key' => $productInfo['images'][0],
      ]);

      foreach ($productInfo['images'] as $image) {
        ProductImage::create([
          'product_id' => $product->id,
          'image_key' => $image,
        ]);
      }

      foreach (Language::ALL_KEYS as $locale) {
        ProductTranslation::create([
          'product_id' => $product->id,
          'language_id' => $this->getLanguageIdByLocale($locale),
          'title' => $productInfo['title'][$locale],
          'description' => $productInfo['description'][$locale],
        ]);
      }
    }
  }

  private $products = [
    // #region - flowers
    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Composition Rose',
        Language::LOCALE_RU_RU => 'Композиция Роза',
        Language::LOCALE_HY_AM => 'Կոմպոզիցիա Վարդեր',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 12500,
      'images' => [
        'https://images.unsplash.com/photo-1582794543139-8ac9cb0f7b11?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=627&q=80',
        'https://images.unsplash.com/photo-1468327768560-75b778cbb551?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1457089328109-e5d9bd499191?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=663&q=80',
      ],
    ],

    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Rose',
        Language::LOCALE_RU_RU => 'Роза',
        Language::LOCALE_HY_AM => 'Վարդեր',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 750,
      'images' => [
        'https://images.unsplash.com/photo-1613539246066-78db6ec4ff0f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=686&q=80',
        'https://images.unsplash.com/photo-1613539246066-78db6ec4ff0f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=686&q=80',
        'https://images.unsplash.com/photo-1613539246066-78db6ec4ff0f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=686&q=80',
      ],
    ],

    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Liana',
        Language::LOCALE_RU_RU => 'Лиана',
        Language::LOCALE_HY_AM => 'Լիանա',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 2500,
      'images' => [
        'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
      ],
    ],

    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Chrysanthemum',
        Language::LOCALE_RU_RU => 'Хризантема',
        Language::LOCALE_HY_AM => 'Քրիզանթեմ',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 2000,
      'images' => [
        'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1508808703020-ef18109db02f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
      ],
    ],

    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Calla lily',
        Language::LOCALE_RU_RU => 'Калла Лили',
        Language::LOCALE_HY_AM => 'Կալա շուշան',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 2000,
      'images' => [
        'https://images.unsplash.com/photo-1600647993560-11a92e039466?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1600647993560-11a92e039466?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1600647993560-11a92e039466?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
      ],
    ],

    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Violet',
        Language::LOCALE_RU_RU => 'Фиолетовый',
        Language::LOCALE_HY_AM => 'Մանուշակ',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 2600,
      'images' => [
        'https://images.unsplash.com/photo-1519378058457-4c29a0a2efac?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=704&q=80',
        'https://images.unsplash.com/photo-1519378058457-4c29a0a2efac?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=704&q=80',
        'https://images.unsplash.com/photo-1519378058457-4c29a0a2efac?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=704&q=80',
      ],
    ],

    [
      'category' => Category::KEY_FLOWERS,
      'title' => [
        Language::LOCALE_EN_US => 'Gerbera',
        Language::LOCALE_RU_RU => 'Гербера',
        Language::LOCALE_HY_AM => 'Գերբերա',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 2300,
      'images' => [
        'https://images.unsplash.com/photo-1508610048659-a06b669e3321?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80',
        'https://images.unsplash.com/photo-1508610048659-a06b669e3321?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80',
        'https://images.unsplash.com/photo-1508610048659-a06b669e3321?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=735&q=80',
      ],
    ],
    // #endregion

    // #region - gifts
    [
      'category' => Category::KEY_GIFTS,
      'title' => [
        Language::LOCALE_EN_US => 'Gift',
        Language::LOCALE_RU_RU => 'Подарок',
        Language::LOCALE_HY_AM => 'Նվեր',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 3200,
      'images' => [
        'https://images.unsplash.com/photo-1607344645866-009c320b63e0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80',
        'https://images.unsplash.com/photo-1607344645866-009c320b63e0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80',
        'https://images.unsplash.com/photo-1607344645866-009c320b63e0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80',
      ],
    ],

    [
      'category' => Category::KEY_GIFTS,
      'title' => [
        Language::LOCALE_EN_US => 'Santa Claus',
        Language::LOCALE_RU_RU => 'Санта Клаус',
        Language::LOCALE_HY_AM => 'Ձմեռ Պապ',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 2300,
      'images' => [
        'https://images.unsplash.com/photo-1575384043001-f37f48835528?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1575384043001-f37f48835528?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1575384043001-f37f48835528?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
      ],
    ],
    // #endregion

    // #region - talking wines
    [
      'category' => Category::KEY_TALKING_WINES,
      'title' => [
        Language::LOCALE_EN_US => 'Talking wine 1',
        Language::LOCALE_RU_RU => 'Говорящее вино 1',
        Language::LOCALE_HY_AM => 'Խոսող գինի 1',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 7680,
      'images' => [
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
      ],
    ],

    [
      'category' => Category::KEY_TALKING_WINES,
      'title' => [
        Language::LOCALE_EN_US => 'Talking wine 2',
        Language::LOCALE_RU_RU => 'Говорящее вино 2',
        Language::LOCALE_HY_AM => 'Խոսող գինի 2',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 9600,
      'images' => [
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
      ],
    ],

    [
      'category' => Category::KEY_TALKING_WINES,
      'title' => [
        Language::LOCALE_EN_US => 'Talking wine 3',
        Language::LOCALE_RU_RU => 'Говорящее вино 3',
        Language::LOCALE_HY_AM => 'Խոսող գինի 3',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 6350,
      'images' => [
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1582731321091-73a0398a6bfd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
      ],
    ],
    // #endregion

    // #region - wedding accessories
    [
      'category' => Category::KEY_TALKING_WINES,
      'title' => [
        Language::LOCALE_EN_US => 'Wedding accessory 1',
        Language::LOCALE_RU_RU => 'Свадебный аксессуар 1',
        Language::LOCALE_HY_AM => 'Հարսանեկան աքսեսուար 1',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 18000,
      'images' => [
        'https://images.unsplash.com/photo-1615653868225-ce1d35288ec3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80',
        'https://images.unsplash.com/photo-1615653868225-ce1d35288ec3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80',
        'https://images.unsplash.com/photo-1615653868225-ce1d35288ec3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80',
      ],
    ],
    [
      'category' => Category::KEY_TALKING_WINES,
      'title' => [
        Language::LOCALE_EN_US => 'Wedding accessory 3',
        Language::LOCALE_RU_RU => 'Свадебный аксессуар 3',
        Language::LOCALE_HY_AM => 'Հարսանեկան աքսեսուար 3',
      ],
      'description' => [
        Language::LOCALE_EN_US => 'English description goes here.',
        Language::LOCALE_RU_RU => 'Русское описание здесь.',
        Language::LOCALE_HY_AM => 'Հայերեն նկարագրությունը գնում է այստեղ։',
      ],
      'price' => 65000,
      'images' => [
        'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
        'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
      ],
    ],
    // #endregion
  ];
}
