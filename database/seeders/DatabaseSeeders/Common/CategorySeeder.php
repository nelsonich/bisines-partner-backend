<?php

namespace Database\Seeders\DatabaseSeeders\Common;

use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Language;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
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

  private function createCategories()
  {
    foreach ($this->categories as $categoryKey => $categoryInfo) {
      $category = Category::query()
        ->where('key', $categoryKey)
        ->first();

      if (is_null($category)) {
        $category = new Category();
        $category->key = $categoryKey;
      }

      $category->image_key = $categoryInfo['image'];
      $category->save();

      foreach ($categoryInfo['translations'] as $locale => $content) {
        $categoryTranslation = CategoryTranslation::query()
          ->where('category_id', $category->id)
          ->where('language_id', $this->languageIds[$locale])
          ->first();

        if (is_null($categoryTranslation)) {
          $categoryTranslation = new CategoryTranslation();
          $categoryTranslation->category_id = $category->id;
          $categoryTranslation->language_id = $this->languageIds[$locale];
        }

        $categoryTranslation->title = $content;
        $categoryTranslation->save();
      }
    }
  }

  public function run()
  {
    $this->fillLanguageIds();
    $this->createCategories();
  }

  private $categories = [
    Category::KEY_FLOWERS => [
      'image' =>
        'https://images.unsplash.com/photo-1526047932273-341f2a7631f9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80',
      'translations' => [
        Language::LOCALE_EN_US => 'Flowers',
        Language::LOCALE_HY_AM => 'Ծաղիկներ',
        Language::LOCALE_RU_RU => 'Цветы',
      ],
    ],
    Category::KEY_GIFTS => [
      'image' =>
        'https://plus.unsplash.com/premium_photo-1664288966397-1888544fadd7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80',
      'translations' => [
        Language::LOCALE_EN_US => 'Gifts',
        Language::LOCALE_HY_AM => 'Նվերներ',
        Language::LOCALE_RU_RU => 'Подарки',
      ],
    ],
    Category::KEY_TALKING_WINES => [
      'image' =>
        'https://images.unsplash.com/photo-1574612842238-238af45614d6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
      'translations' => [
        Language::LOCALE_EN_US => 'Talking wines',
        Language::LOCALE_HY_AM => 'Խոսող գինիներ',
        Language::LOCALE_RU_RU => 'Говорящие вина',
      ],
    ],
    Category::KEY_WEDDING_ACCESSORIES => [
      'image' =>
        'https://plus.unsplash.com/premium_photo-1675003662281-346b109ad042?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
      'translations' => [
        Language::LOCALE_EN_US => 'Wedding accessories',
        Language::LOCALE_HY_AM => 'Հարսանեկան պարագաներ',
        Language::LOCALE_RU_RU => 'Свадебные аксессуары',
      ],
    ],
  ];
}
