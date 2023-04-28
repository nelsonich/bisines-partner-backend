<?php

namespace Database\Seeders\DatabaseSeeders\Common;

use App\Models\Category\Category;
use App\Models\Language;
use App\Models\Product\ProductField;
use App\Models\Product\ProductFieldTranslation;
use App\Models\Product\ProductFieldValue;
use App\Models\Product\ProductFieldValueTranslation;
use Illuminate\Database\Seeder;

class ProductFieldTableSeeder extends Seeder
{
  // Product field keys
  const KEY_COLOR = 'color';
  const KEY_CONTAINER = 'container';
  const KEY_TYPE = 'type';

  private $languageIds = [];

  private function fillLanguageIds()
  {
    foreach (Language::ALL_KEYS as $locale) {
      $language = Language::query()
        ->where('locale', $locale)
        ->first();

      $this->languageIds[$locale] = $language->id;
    }
  }

  private function createProductField()
  {
    foreach ($this->productFields as $item) {
      $category = Category::query()
        ->where('key', $item['category'])
        ->first();

      $productField = ProductField::firstOrCreate(
        [
          'category_id' => $category->id,
          'key' => $item['key'],
          'type' => $item['type'],
        ],
        [
          'category_id' => $category->id,
          'key' => $item['key'],
          'type' => $item['type'],
        ]
      );

      foreach ($item['translations'] as $locale => $content) {
        ProductFieldTranslation::firstOrCreate(
          [
            'product_field_id' => $productField->id,
            'language_id' => $this->languageIds[$locale],
          ],
          [
            'product_field_id' => $productField->id,
            'language_id' => $this->languageIds[$locale],
            'title' => $content,
          ]
        );
      }

      if ($item['type'] !== ProductField::TYPE_INPUT) {
        $this->createProductFieldValues($productField->id, $item['values']);
      }
    }
  }

  private function createProductFieldValues($productFieldId, $values)
  {
    foreach ($values as $key => $value) {
      $productFieldValue = ProductFieldValue::firstOrCreate(
        [
          'product_field_id' => $productFieldId,
          'key' => $key,
        ],
        [
          'product_field_id' => $productFieldId,
          'key' => $key,
        ]
      );

      foreach ($value['translations'] as $locale => $content) {
        ProductFieldValueTranslation::firstOrCreate(
          [
            'product_field_value_id' => $productFieldValue->id,
            'language_id' => $this->languageIds[$locale],
          ],
          [
            'product_field_value_id' => $productFieldValue->id,
            'language_id' => $this->languageIds[$locale],
            'title' => $content,
          ]
        );
      }
    }
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->fillLanguageIds();
    $this->createProductField();
  }

  private $productFields = [
    // Flowers
    [
      'category' => Category::KEY_FLOWERS,
      'key' => self::KEY_COLOR,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Color',
        Language::LOCALE_HY_AM => 'Գույն',
        Language::LOCALE_RU_RU => 'Цвет',
      ],
      'values' => [
        ProductFieldValue::COLOR_RED => [
          'translations' => [
            Language::LOCALE_EN_US => 'Red',
            Language::LOCALE_HY_AM => 'Կարմիր',
            Language::LOCALE_RU_RU => 'Красный',
          ],
        ],
        ProductFieldValue::COLOR_GREEN => [
          'translations' => [
            Language::LOCALE_EN_US => 'Green',
            Language::LOCALE_HY_AM => 'Կանաչ',
            Language::LOCALE_RU_RU => 'Зеленый',
          ],
        ],
        ProductFieldValue::COLOR_PINK => [
          'translations' => [
            Language::LOCALE_EN_US => 'Pink',
            Language::LOCALE_HY_AM => 'Վարդագույն',
            Language::LOCALE_RU_RU => 'Розовый',
          ],
        ],
        ProductFieldValue::COLOR_BLUE => [
          'translations' => [
            Language::LOCALE_EN_US => 'Blue',
            Language::LOCALE_HY_AM => 'Կապույտ',
            Language::LOCALE_RU_RU => 'Синий',
          ],
        ],
        ProductFieldValue::COLOR_YELLOW => [
          'translations' => [
            Language::LOCALE_EN_US => 'Yellow',
            Language::LOCALE_HY_AM => 'Դեղին',
            Language::LOCALE_RU_RU => 'Желтый',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_FLOWERS,
      'key' => self::KEY_CONTAINER,
      'type' => ProductField::TYPE_SINGLE,
      'translations' => [
        Language::LOCALE_EN_US => 'Container',
        Language::LOCALE_HY_AM => 'Տարա',
        Language::LOCALE_RU_RU => 'Контейнер',
      ],
      'values' => [
        ProductFieldValue::CONTAINER_CART => [
          'translations' => [
            Language::LOCALE_EN_US => 'Cart',
            Language::LOCALE_HY_AM => 'Զամբյուղ',
            Language::LOCALE_RU_RU => 'Корзина',
          ],
        ],
        ProductFieldValue::CONTAINER_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Box',
            Language::LOCALE_HY_AM => 'Տուփ',
            Language::LOCALE_RU_RU => 'Коробка',
          ],
        ],
        ProductFieldValue::CONTAINER_WOODEN_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Wooden Box',
            Language::LOCALE_HY_AM => 'Փայտե տուփ',
            Language::LOCALE_RU_RU => 'Деревянная коробка',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_FLOWERS,
      'key' => self::KEY_TYPE,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Type',
        Language::LOCALE_HY_AM => 'Տեսակ',
        Language::LOCALE_RU_RU => 'Тип',
      ],
      'values' => [
        ProductFieldValue::TYPE_COMPOSITION_SWEETS => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition sweets',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիայի քաղցրավենիք',
            Language::LOCALE_RU_RU => 'Композиция конфет',
          ],
        ],
        ProductFieldValue::TYPE_A_BUNCH => [
          'translations' => [
            Language::LOCALE_EN_US => 'A bunch',
            Language::LOCALE_HY_AM => 'Մի փունջ',
            Language::LOCALE_RU_RU => 'Куча',
          ],
        ],
        ProductFieldValue::TYPE_BY_PIECE => [
          'translations' => [
            Language::LOCALE_EN_US => 'A piece',
            Language::LOCALE_HY_AM => 'Կտոր մը',
            Language::LOCALE_RU_RU => 'Кусок',
          ],
        ],
        ProductFieldValue::TYPE_COMPOSITION => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիա',
            Language::LOCALE_RU_RU => 'Композиция',
          ],
        ],
      ],
    ],

    // Gifts
    [
      'category' => Category::KEY_GIFTS,
      'key' => self::KEY_COLOR,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Color',
        Language::LOCALE_HY_AM => 'Գույն',
        Language::LOCALE_RU_RU => 'Цвет',
      ],
      'values' => [
        ProductFieldValue::COLOR_RED => [
          'translations' => [
            Language::LOCALE_EN_US => 'Red',
            Language::LOCALE_HY_AM => 'Կարմիր',
            Language::LOCALE_RU_RU => 'Красный',
          ],
        ],
        ProductFieldValue::COLOR_GREEN => [
          'translations' => [
            Language::LOCALE_EN_US => 'Green',
            Language::LOCALE_HY_AM => 'Կանաչ',
            Language::LOCALE_RU_RU => 'Зеленый',
          ],
        ],
        ProductFieldValue::COLOR_PINK => [
          'translations' => [
            Language::LOCALE_EN_US => 'Pink',
            Language::LOCALE_HY_AM => 'Վարդագույն',
            Language::LOCALE_RU_RU => 'Розовый',
          ],
        ],
        ProductFieldValue::COLOR_BLUE => [
          'translations' => [
            Language::LOCALE_EN_US => 'Blue',
            Language::LOCALE_HY_AM => 'Կապույտ',
            Language::LOCALE_RU_RU => 'Синий',
          ],
        ],
        ProductFieldValue::COLOR_YELLOW => [
          'translations' => [
            Language::LOCALE_EN_US => 'Yellow',
            Language::LOCALE_HY_AM => 'Դեղին',
            Language::LOCALE_RU_RU => 'Желтый',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_GIFTS,
      'key' => self::KEY_CONTAINER,
      'type' => ProductField::TYPE_SINGLE,
      'translations' => [
        Language::LOCALE_EN_US => 'Container',
        Language::LOCALE_HY_AM => 'Տարա',
        Language::LOCALE_RU_RU => 'Контейнер',
      ],
      'values' => [
        ProductFieldValue::CONTAINER_CART => [
          'translations' => [
            Language::LOCALE_EN_US => 'Cart',
            Language::LOCALE_HY_AM => 'Զամբյուղ',
            Language::LOCALE_RU_RU => 'Корзина',
          ],
        ],
        ProductFieldValue::CONTAINER_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Box',
            Language::LOCALE_HY_AM => 'Տուփ',
            Language::LOCALE_RU_RU => 'Коробка',
          ],
        ],
        ProductFieldValue::CONTAINER_WOODEN_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Wooden Box',
            Language::LOCALE_HY_AM => 'Փայտե տուփ',
            Language::LOCALE_RU_RU => 'Деревянная коробка',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_GIFTS,
      'key' => self::KEY_TYPE,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Type',
        Language::LOCALE_HY_AM => 'Տեսակ',
        Language::LOCALE_RU_RU => 'Тип',
      ],
      'values' => [
        ProductFieldValue::TYPE_COMPOSITION_SWEETS => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition sweets',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիայի քաղցրավենիք',
            Language::LOCALE_RU_RU => 'Композиция конфет',
          ],
        ],
        ProductFieldValue::TYPE_A_BUNCH => [
          'translations' => [
            Language::LOCALE_EN_US => 'A bunch',
            Language::LOCALE_HY_AM => 'Մի փունջ',
            Language::LOCALE_RU_RU => 'Куча',
          ],
        ],
        ProductFieldValue::TYPE_BY_PIECE => [
          'translations' => [
            Language::LOCALE_EN_US => 'A piece',
            Language::LOCALE_HY_AM => 'Կտոր մը',
            Language::LOCALE_RU_RU => 'Кусок',
          ],
        ],
        ProductFieldValue::TYPE_COMPOSITION => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիա',
            Language::LOCALE_RU_RU => 'Композиция',
          ],
        ],
      ],
    ],

    // Talking Wines
    [
      'category' => Category::KEY_TALKING_WINES,
      'key' => self::KEY_COLOR,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Color',
        Language::LOCALE_HY_AM => 'Գույն',
        Language::LOCALE_RU_RU => 'Цвет',
      ],
      'values' => [
        ProductFieldValue::COLOR_RED => [
          'translations' => [
            Language::LOCALE_EN_US => 'Red',
            Language::LOCALE_HY_AM => 'Կարմիր',
            Language::LOCALE_RU_RU => 'Красный',
          ],
        ],
        ProductFieldValue::COLOR_GREEN => [
          'translations' => [
            Language::LOCALE_EN_US => 'Green',
            Language::LOCALE_HY_AM => 'Կանաչ',
            Language::LOCALE_RU_RU => 'Зеленый',
          ],
        ],
        ProductFieldValue::COLOR_PINK => [
          'translations' => [
            Language::LOCALE_EN_US => 'Pink',
            Language::LOCALE_HY_AM => 'Վարդագույն',
            Language::LOCALE_RU_RU => 'Розовый',
          ],
        ],
        ProductFieldValue::COLOR_BLUE => [
          'translations' => [
            Language::LOCALE_EN_US => 'Blue',
            Language::LOCALE_HY_AM => 'Կապույտ',
            Language::LOCALE_RU_RU => 'Синий',
          ],
        ],
        ProductFieldValue::COLOR_YELLOW => [
          'translations' => [
            Language::LOCALE_EN_US => 'Yellow',
            Language::LOCALE_HY_AM => 'Դեղին',
            Language::LOCALE_RU_RU => 'Желтый',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_TALKING_WINES,
      'key' => self::KEY_CONTAINER,
      'type' => ProductField::TYPE_SINGLE,
      'translations' => [
        Language::LOCALE_EN_US => 'Container',
        Language::LOCALE_HY_AM => 'Տարա',
        Language::LOCALE_RU_RU => 'Контейнер',
      ],
      'values' => [
        ProductFieldValue::CONTAINER_CART => [
          'translations' => [
            Language::LOCALE_EN_US => 'Cart',
            Language::LOCALE_HY_AM => 'Զամբյուղ',
            Language::LOCALE_RU_RU => 'Корзина',
          ],
        ],
        ProductFieldValue::CONTAINER_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Box',
            Language::LOCALE_HY_AM => 'Տուփ',
            Language::LOCALE_RU_RU => 'Коробка',
          ],
        ],
        ProductFieldValue::CONTAINER_WOODEN_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Wooden Box',
            Language::LOCALE_HY_AM => 'Փայտե տուփ',
            Language::LOCALE_RU_RU => 'Деревянная коробка',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_TALKING_WINES,
      'key' => self::KEY_TYPE,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Type',
        Language::LOCALE_HY_AM => 'Տեսակ',
        Language::LOCALE_RU_RU => 'Тип',
      ],
      'values' => [
        ProductFieldValue::TYPE_COMPOSITION_SWEETS => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition sweets',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիայի քաղցրավենիք',
            Language::LOCALE_RU_RU => 'Композиция конфет',
          ],
        ],
        ProductFieldValue::TYPE_A_BUNCH => [
          'translations' => [
            Language::LOCALE_EN_US => 'A bunch',
            Language::LOCALE_HY_AM => 'Մի փունջ',
            Language::LOCALE_RU_RU => 'Куча',
          ],
        ],
        ProductFieldValue::TYPE_BY_PIECE => [
          'translations' => [
            Language::LOCALE_EN_US => 'A piece',
            Language::LOCALE_HY_AM => 'Կտոր մը',
            Language::LOCALE_RU_RU => 'Кусок',
          ],
        ],
        ProductFieldValue::TYPE_COMPOSITION => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիա',
            Language::LOCALE_RU_RU => 'Композиция',
          ],
        ],
      ],
    ],

    // Wedding Accessories
    [
      'category' => Category::KEY_WEDDING_ACCESSORIES,
      'key' => self::KEY_COLOR,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Color',
        Language::LOCALE_HY_AM => 'Գույն',
        Language::LOCALE_RU_RU => 'Цвет',
      ],
      'values' => [
        ProductFieldValue::COLOR_RED => [
          'translations' => [
            Language::LOCALE_EN_US => 'Red',
            Language::LOCALE_HY_AM => 'Կարմիր',
            Language::LOCALE_RU_RU => 'Красный',
          ],
        ],
        ProductFieldValue::COLOR_GREEN => [
          'translations' => [
            Language::LOCALE_EN_US => 'Green',
            Language::LOCALE_HY_AM => 'Կանաչ',
            Language::LOCALE_RU_RU => 'Зеленый',
          ],
        ],
        ProductFieldValue::COLOR_PINK => [
          'translations' => [
            Language::LOCALE_EN_US => 'Pink',
            Language::LOCALE_HY_AM => 'Վարդագույն',
            Language::LOCALE_RU_RU => 'Розовый',
          ],
        ],
        ProductFieldValue::COLOR_BLUE => [
          'translations' => [
            Language::LOCALE_EN_US => 'Blue',
            Language::LOCALE_HY_AM => 'Կապույտ',
            Language::LOCALE_RU_RU => 'Синий',
          ],
        ],
        ProductFieldValue::COLOR_YELLOW => [
          'translations' => [
            Language::LOCALE_EN_US => 'Yellow',
            Language::LOCALE_HY_AM => 'Դեղին',
            Language::LOCALE_RU_RU => 'Желтый',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_WEDDING_ACCESSORIES,
      'key' => self::KEY_CONTAINER,
      'type' => ProductField::TYPE_SINGLE,
      'translations' => [
        Language::LOCALE_EN_US => 'Container',
        Language::LOCALE_HY_AM => 'Տարա',
        Language::LOCALE_RU_RU => 'Контейнер',
      ],
      'values' => [
        ProductFieldValue::CONTAINER_CART => [
          'translations' => [
            Language::LOCALE_EN_US => 'Cart',
            Language::LOCALE_HY_AM => 'Զամբյուղ',
            Language::LOCALE_RU_RU => 'Корзина',
          ],
        ],
        ProductFieldValue::CONTAINER_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Box',
            Language::LOCALE_HY_AM => 'Տուփ',
            Language::LOCALE_RU_RU => 'Коробка',
          ],
        ],
        ProductFieldValue::CONTAINER_WOODEN_BOX => [
          'translations' => [
            Language::LOCALE_EN_US => 'Wooden Box',
            Language::LOCALE_HY_AM => 'Փայտե տուփ',
            Language::LOCALE_RU_RU => 'Деревянная коробка',
          ],
        ],
      ],
    ],
    [
      'category' => Category::KEY_WEDDING_ACCESSORIES,
      'key' => self::KEY_TYPE,
      'type' => ProductField::TYPE_GROUP,
      'translations' => [
        Language::LOCALE_EN_US => 'Type',
        Language::LOCALE_HY_AM => 'Տեսակ',
        Language::LOCALE_RU_RU => 'Тип',
      ],
      'values' => [
        ProductFieldValue::TYPE_COMPOSITION_SWEETS => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition sweets',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիայի քաղցրավենիք',
            Language::LOCALE_RU_RU => 'Композиция конфет',
          ],
        ],
        ProductFieldValue::TYPE_A_BUNCH => [
          'translations' => [
            Language::LOCALE_EN_US => 'A bunch',
            Language::LOCALE_HY_AM => 'Մի փունջ',
            Language::LOCALE_RU_RU => 'Куча',
          ],
        ],
        ProductFieldValue::TYPE_BY_PIECE => [
          'translations' => [
            Language::LOCALE_EN_US => 'A piece',
            Language::LOCALE_HY_AM => 'Կտոր մը',
            Language::LOCALE_RU_RU => 'Кусок',
          ],
        ],
        ProductFieldValue::TYPE_COMPOSITION => [
          'translations' => [
            Language::LOCALE_EN_US => 'Composition',
            Language::LOCALE_HY_AM => 'Կոմպոզիցիա',
            Language::LOCALE_RU_RU => 'Композиция',
          ],
        ],
      ],
    ],
  ];
}
