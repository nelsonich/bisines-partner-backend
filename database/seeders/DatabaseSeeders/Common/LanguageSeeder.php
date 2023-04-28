<?php

namespace Database\Seeders\DatabaseSeeders\Common;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
  public function run()
  {
    foreach (Language::ALL_KEYS as $locale) {
      $language = Language::query()
        ->where('locale', $locale)
        ->first();

      if (is_null($language)) {
        Language::create([
          'locale' => $locale,
        ]);
      }
    }
  }
}
