<?php

namespace Database\Seeders\DatabaseSeeders\Common;

use App\Models\Language;
use App\Models\Shipping\ShippingCity;
use App\Models\Shipping\ShippingCityTranslation;
use Illuminate\Database\Seeder;

class ShippingCitiesTableSeeder extends Seeder
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

  private function createShippingCities()
  {
    foreach ($this->shippingDetails as $item) {
      $shippingCity = ShippingCity::firstOrCreate(
        [
          'slug' => $item['slug'],
          'cost' => $item['cost'],
        ],
        [
          'slug' => $item['slug'],
          'cost' => $item['cost'],
        ]
      );

      foreach ($item['translations'] as $locale => $translation) {
        ShippingCityTranslation::firstOrCreate(
          [
            'shipping_city_id' => $shippingCity->id,
            'language_id' => $this->languageIds[$locale],
          ],
          [
            'shipping_city_id' => $shippingCity->id,
            'language_id' => $this->languageIds[$locale],
            'name' => $translation,
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
    $this->createShippingCities();
  }

  private $shippingDetails = [
    [
      'slug' => 'yerevan',
      'cost' => 1000,
      'translations' => [
        Language::LOCALE_EN_US => 'Yerevan',
        Language::LOCALE_HY_AM => 'Երևան',
        Language::LOCALE_RU_RU => 'Ереван',
      ],
    ],
    [
      'slug' => 'abovyan',
      'cost' => 2100,
      'translations' => [
        Language::LOCALE_EN_US => 'Abovyan',
        Language::LOCALE_HY_AM => 'Աբովյան',
        Language::LOCALE_RU_RU => 'Абовян',
      ],
    ],
    [
      'slug' => 'alaverdi',
      'cost' => 19300,
      'translations' => [
        Language::LOCALE_EN_US => 'Alaverdi',
        Language::LOCALE_HY_AM => 'Ալավերդի',
        Language::LOCALE_RU_RU => 'Алаверди',
      ],
    ],
    [
      'slug' => 'aghveran',
      'cost' => 5000,
      'translations' => [
        Language::LOCALE_EN_US => 'Aghveran',
        Language::LOCALE_HY_AM => 'Աղվերան',
        Language::LOCALE_RU_RU => 'Агверан',
      ],
    ],
    [
      'slug' => 'aparan',
      'cost' => 6500,
      'translations' => [
        Language::LOCALE_EN_US => 'Aparan',
        Language::LOCALE_HY_AM => 'Ապարան',
        Language::LOCALE_RU_RU => 'Апаран',
      ],
    ],
    [
      'slug' => 'Arinj',
      'cost' => 1400,
      'translations' => [
        Language::LOCALE_EN_US => 'Arinj',
        Language::LOCALE_HY_AM => 'Առինջ',
        Language::LOCALE_RU_RU => 'Ариндж',
      ],
    ],
    [
      'slug' => 'аyntap',
      'cost' => 1400,
      'translations' => [
        Language::LOCALE_EN_US => 'Ayntap',
        Language::LOCALE_HY_AM => 'Այնթափ',
        Language::LOCALE_RU_RU => 'Айнтап',
      ],
    ],
    [
      'slug' => 'аyrum',
      'cost' => 25000,
      'translations' => [
        Language::LOCALE_EN_US => 'Ayrum',
        Language::LOCALE_HY_AM => 'Այրում',
        Language::LOCALE_RU_RU => 'Айрум',
      ],
    ],
    [
      'slug' => 'ashocq',
      'cost' => 19500,
      'translations' => [
        Language::LOCALE_EN_US => 'Ashocq',
        Language::LOCALE_HY_AM => 'Աշոցք',
        Language::LOCALE_RU_RU => 'Ашоцк',
      ],
    ],
    [
      'slug' => 'ashtarak',
      'cost' => 2300,
      'translations' => [
        Language::LOCALE_EN_US => 'Ashtarak',
        Language::LOCALE_HY_AM => 'Աշտարակ',
        Language::LOCALE_RU_RU => 'Аштарак',
      ],
    ],
    [
      'slug' => 'aragats-village',
      'cost' => 3500,
      'translations' => [
        Language::LOCALE_EN_US => 'Aragats village',
        Language::LOCALE_HY_AM => 'Արագած  գյուղ',
        Language::LOCALE_RU_RU => 'село Арагац',
      ],
    ],
    [
      'slug' => 'ararat',
      'cost' => 5700,
      'translations' => [
        Language::LOCALE_EN_US => 'Ararat',
        Language::LOCALE_HY_AM => 'Արարատ',
        Language::LOCALE_RU_RU => 'Арарат',
      ],
    ],
    [
      'slug' => 'argavand',
      'cost' => 1400,
      'translations' => [
        Language::LOCALE_EN_US => 'Argavand',
        Language::LOCALE_HY_AM => 'Արգավանդ',
        Language::LOCALE_RU_RU => 'Аргаванд',
      ],
    ],
    [
      'slug' => 'armavir',
      'cost' => 5000,
      'translations' => [
        Language::LOCALE_EN_US => 'Armavir',
        Language::LOCALE_HY_AM => 'Արմավիր',
        Language::LOCALE_RU_RU => 'Армавир',
      ],
    ],
    [
      'slug' => 'artashat',
      'cost' => 4400,
      'translations' => [
        Language::LOCALE_EN_US => 'Artashat',
        Language::LOCALE_HY_AM => 'Արտաշատ',
        Language::LOCALE_RU_RU => 'Арташат',
      ],
    ],
    [
      'slug' => 'artik',
      'cost' => 13500,
      'translations' => [
        Language::LOCALE_EN_US => 'Artik',
        Language::LOCALE_HY_AM => 'Արթիկ',
        Language::LOCALE_RU_RU => 'Артик',
      ],
    ],
    [
      'slug' => 'berd',
      'cost' => 22000,
      'translations' => [
        Language::LOCALE_EN_US => 'Berd',
        Language::LOCALE_HY_AM => 'Բերդ',
        Language::LOCALE_RU_RU => 'Берд',
      ],
    ],
    [
      'slug' => 'byurakan',
      'cost' => 3600,
      'translations' => [
        Language::LOCALE_EN_US => 'Byurakan',
        Language::LOCALE_HY_AM => 'Բյուրական',
        Language::LOCALE_RU_RU => 'Бйуракан',
      ],
    ],
    [
      'slug' => 'garni',
      'cost' => 3000,
      'translations' => [
        Language::LOCALE_EN_US => 'Garni',
        Language::LOCALE_HY_AM => 'Գառնի',
        Language::LOCALE_RU_RU => 'Гарни',
      ],
    ],
    [
      'slug' => 'goris',
      'cost' => 27000,
      'translations' => [
        Language::LOCALE_EN_US => 'Goris',
        Language::LOCALE_HY_AM => 'Գորիս',
        Language::LOCALE_RU_RU => 'Горис',
      ],
    ],
    [
      'slug' => 'gavar',
      'cost' => 10500,
      'translations' => [
        Language::LOCALE_EN_US => 'Gavar',
        Language::LOCALE_HY_AM => 'Գավառ',
        Language::LOCALE_RU_RU => 'Гавар',
      ],
    ],
    [
      'slug' => 'gyumri',
      'cost' => 14500,
      'translations' => [
        Language::LOCALE_EN_US => 'Gyumri',
        Language::LOCALE_HY_AM => 'Գյումրի',
        Language::LOCALE_RU_RU => 'Гюмри',
      ],
    ],
    [
      'slug' => 'dilijan',
      'cost' => 10500,
      'translations' => [
        Language::LOCALE_EN_US => 'Dilijan',
        Language::LOCALE_HY_AM => 'Դիլիջան',
        Language::LOCALE_RU_RU => 'Дилижан',
      ],
    ],
    [
      'slug' => 'yeghegnadzor',
      'cost' => 14000,
      'translations' => [
        Language::LOCALE_EN_US => 'Yeghegnadzor',
        Language::LOCALE_HY_AM => 'Եղեգնաձոր',
        Language::LOCALE_RU_RU => 'Ехегнадзор',
      ],
    ],
    [
      'slug' => 'yeghvard',
      'cost' => 2300,
      'translations' => [
        Language::LOCALE_EN_US => 'Yeghvard',
        Language::LOCALE_HY_AM => 'Եղվարդ',
        Language::LOCALE_RU_RU => 'Ехвард',
      ],
    ],
    [
      'slug' => 'zovuni',
      'cost' => 1500,
      'translations' => [
        Language::LOCALE_EN_US => 'Zovuni',
        Language::LOCALE_HY_AM => 'Զովունի',
        Language::LOCALE_RU_RU => 'Зовуни',
      ],
    ],
    [
      'slug' => 'zvartnots-international-airport',
      'cost' => 1700,
      'translations' => [
        Language::LOCALE_EN_US => 'Zvartnots International Airport',
        Language::LOCALE_HY_AM => 'Զվարթնոց միջազգային օդանավակայան',
        Language::LOCALE_RU_RU => 'Международный аэропорт Звартноц',
      ],
    ],
    [
      'slug' => 'talin',
      'cost' => 7500,
      'translations' => [
        Language::LOCALE_EN_US => 'Talin',
        Language::LOCALE_HY_AM => 'Թալին',
        Language::LOCALE_RU_RU => 'Талин',
      ],
    ],
    [
      'slug' => 'ijevan',
      'cost' => 14500,
      'translations' => [
        Language::LOCALE_EN_US => 'Ijevan',
        Language::LOCALE_HY_AM => 'Իջևան',
        Language::LOCALE_RU_RU => 'Иджеван',
      ],
    ],
    [
      'slug' => 'chambarak',
      'cost' => 14000,
      'translations' => [
        Language::LOCALE_EN_US => 'Chambarak',
        Language::LOCALE_HY_AM => 'Ճամբարակ',
        Language::LOCALE_RU_RU => 'Чамбарак',
      ],
    ],
    [
      'slug' => 'charentsavan',
      'cost' => 4000,
      'translations' => [
        Language::LOCALE_EN_US => 'Charentsavan',
        Language::LOCALE_HY_AM => 'Չարենցավան',
        Language::LOCALE_RU_RU => 'Чаренцаван',
      ],
    ],
    [
      'slug' => 'dzoraghbyur',
      'cost' => 1700,
      'translations' => [
        Language::LOCALE_EN_US => 'Dzoraghbyur',
        Language::LOCALE_HY_AM => 'Ձորաղբյուր',
        Language::LOCALE_RU_RU => 'Дзорахпюр',
      ],
    ],
    [
      'slug' => 'hrazdan',
      'cost' => 5000,
      'translations' => [
        Language::LOCALE_EN_US => 'Hrazdan',
        Language::LOCALE_HY_AM => 'Հրազդան',
        Language::LOCALE_RU_RU => 'Раздан',
      ],
    ],
    [
      'slug' => 'jermuk',
      'cost' => 18700,
      'translations' => [
        Language::LOCALE_EN_US => 'Jermuk',
        Language::LOCALE_HY_AM => 'Ջերմուկ',
        Language::LOCALE_RU_RU => 'Джермук',
      ],
    ],
    [
      'slug' => 'jrvezh',
      'cost' => 1500,
      'translations' => [
        Language::LOCALE_EN_US => 'Jrvezh',
        Language::LOCALE_HY_AM => 'Ջրվեժ',
        Language::LOCALE_RU_RU => 'Джрвеж',
      ],
    ],
    [
      'slug' => 'kajaran',
      'cost' => 36000,
      'translations' => [
        Language::LOCALE_EN_US => 'Kajaran',
        Language::LOCALE_HY_AM => 'Քաջարան',
        Language::LOCALE_RU_RU => 'Каджаран',
      ],
    ],
    [
      'slug' => 'kapan',
      'cost' => 35000,
      'translations' => [
        Language::LOCALE_EN_US => 'Kapan',
        Language::LOCALE_HY_AM => 'Կապան',
        Language::LOCALE_RU_RU => 'Каджаран',
      ],
    ],
    [
      'slug' => 'kasakh',
      'cost' => 1300,
      'translations' => [
        Language::LOCALE_EN_US => 'Kasakh',
        Language::LOCALE_HY_AM => 'Քասախ',
        Language::LOCALE_RU_RU => 'Касах',
      ],
    ],
    [
      'slug' => 'maralik',
      'cost' => 12500,
      'translations' => [
        Language::LOCALE_EN_US => 'Maralik',
        Language::LOCALE_HY_AM => 'Մարալիկ',
        Language::LOCALE_RU_RU => 'Маралик',
      ],
    ],
    [
      'slug' => 'martuni',
      'cost' => 14000,
      'translations' => [
        Language::LOCALE_EN_US => 'Martuni',
        Language::LOCALE_HY_AM => 'Մարտունի',
        Language::LOCALE_RU_RU => 'Мартуни',
      ],
    ],
    [
      'slug' => 'masis',
      'cost' => 2200,
      'translations' => [
        Language::LOCALE_EN_US => 'Masis',
        Language::LOCALE_HY_AM => 'Մասիս',
        Language::LOCALE_RU_RU => 'Масис',
      ],
    ],
    [
      'slug' => 'meghri',
      'cost' => 38000,
      'translations' => [
        Language::LOCALE_EN_US => 'Meghri',
        Language::LOCALE_HY_AM => 'Մեղրի',
        Language::LOCALE_RU_RU => 'Мегри',
      ],
    ],
    [
      'slug' => 'merdzavan',
      'cost' => 1600,
      'translations' => [
        Language::LOCALE_EN_US => 'Merdzavan',
        Language::LOCALE_HY_AM => 'Մերձավան',
        Language::LOCALE_RU_RU => 'Мердзаван',
      ],
    ],
    [
      'slug' => 'metsamor',
      'cost' => 4000,
      'translations' => [
        Language::LOCALE_EN_US => 'Metsamor',
        Language::LOCALE_HY_AM => 'Մեծամոր',
        Language::LOCALE_RU_RU => 'Мецамор',
      ],
    ],
    [
      'slug' => 'nor-hachn',
      'cost' => 2400,
      'translations' => [
        Language::LOCALE_EN_US => 'Nor Hachn',
        Language::LOCALE_HY_AM => 'Նոր Հաճն',
        Language::LOCALE_RU_RU => 'Нор Ачин',
      ],
    ],
    [
      'slug' => 'nor-kharberd',
      'cost' => 1400,
      'translations' => [
        Language::LOCALE_EN_US => 'Nor Kharberd',
        Language::LOCALE_HY_AM => 'Նոր Խարբերդ',
        Language::LOCALE_RU_RU => 'Нор Харберд',
      ],
    ],
    [
      'slug' => 'norashen',
      'cost' => 1500,
      'translations' => [
        Language::LOCALE_EN_US => 'Norashen',
        Language::LOCALE_HY_AM => 'Նորաշեն',
        Language::LOCALE_RU_RU => 'Норашен',
      ],
    ],
    [
      'slug' => 'noyemberyan',
      'cost' => 20000,
      'translations' => [
        Language::LOCALE_EN_US => 'Noyemberyan',
        Language::LOCALE_HY_AM => 'Նոյեմբերյան',
        Language::LOCALE_RU_RU => 'Ноемберян',
      ],
    ],
    [
      'slug' => 'nubarashen',
      'cost' => 1500,
      'translations' => [
        Language::LOCALE_EN_US => 'Nubarashen',
        Language::LOCALE_HY_AM => 'Նուբարաշեն',
        Language::LOCALE_RU_RU => 'Нубарашен',
      ],
    ],
    [
      'slug' => 'parakar',
      'cost' => 1400,
      'translations' => [
        Language::LOCALE_EN_US => 'Parakar',
        Language::LOCALE_HY_AM => 'Փարաքար',
        Language::LOCALE_RU_RU => 'Паракар',
      ],
    ],
    [
      'slug' => 'proshyan',
      'cost' => 1700,
      'translations' => [
        Language::LOCALE_EN_US => 'Proshyan',
        Language::LOCALE_HY_AM => 'Պրոշյան',
        Language::LOCALE_RU_RU => 'Прошян',
      ],
    ],
    [
      'slug' => 'ptghni',
      'cost' => 1500,
      'translations' => [
        Language::LOCALE_EN_US => 'Ptghni',
        Language::LOCALE_HY_AM => 'Պտղնի',
        Language::LOCALE_RU_RU => 'Птгни',
      ],
    ],
    [
      'slug' => 'sevan',
      'cost' => 7000,
      'translations' => [
        Language::LOCALE_EN_US => 'Sevan',
        Language::LOCALE_HY_AM => 'Սևան',
        Language::LOCALE_RU_RU => 'Севан',
      ],
    ],
    [
      'slug' => 'sisian',
      'cost' => 23800,
      'translations' => [
        Language::LOCALE_EN_US => 'Sisian',
        Language::LOCALE_HY_AM => 'Սիսիան',
        Language::LOCALE_RU_RU => 'Сисиан',
      ],
    ],
    [
      'slug' => 'spitak',
      'cost' => 11000,
      'translations' => [
        Language::LOCALE_EN_US => 'Spitak',
        Language::LOCALE_HY_AM => 'Սպիտակ',
        Language::LOCALE_RU_RU => 'Спитак',
      ],
    ],
    [
      'slug' => 'stepanavan',
      'cost' => 16000,
      'translations' => [
        Language::LOCALE_EN_US => 'Stepanavan',
        Language::LOCALE_HY_AM => 'Ստեփանավան',
        Language::LOCALE_RU_RU => 'Степанаван',
      ],
    ],
    [
      'slug' => 'tsakhkadzor',
      'cost' => 6300,
      'translations' => [
        Language::LOCALE_EN_US => 'Tsakhkadzor',
        Language::LOCALE_HY_AM => 'Ծաղկաձոր',
        Language::LOCALE_RU_RU => 'Цахкадзор',
      ],
    ],
    [
      'slug' => 'vagharshapat',
      'cost' => 2300,
      'translations' => [
        Language::LOCALE_EN_US => 'Vagharshapat',
        Language::LOCALE_HY_AM => 'Վաղարշապատ',
        Language::LOCALE_RU_RU => 'Вагаршапат',
      ],
    ],
    [
      'slug' => 'vanadzor',
      'cost' => 14500,
      'translations' => [
        Language::LOCALE_EN_US => 'Vanadzor',
        Language::LOCALE_HY_AM => 'Վանաձոր',
        Language::LOCALE_RU_RU => 'Ванадзор',
      ],
    ],
    [
      'slug' => 'vardenis',
      'cost' => 17500,
      'translations' => [
        Language::LOCALE_EN_US => 'Vardenis',
        Language::LOCALE_HY_AM => 'Վարդենիս',
        Language::LOCALE_RU_RU => 'Варденис',
      ],
    ],
    [
      'slug' => 'vedi',
      'cost' => 6000,
      'translations' => [
        Language::LOCALE_EN_US => 'Vedi',
        Language::LOCALE_HY_AM => 'Վեդի',
        Language::LOCALE_RU_RU => 'Веди',
      ],
    ],
    [
      'slug' => 'kharberd',
      'cost' => 1500,
      'translations' => [
        Language::LOCALE_EN_US => 'Kharberd',
        Language::LOCALE_HY_AM => 'Խարբերդ',
        Language::LOCALE_RU_RU => 'Харберд',
      ],
    ],
    [
      'slug' => 'tashir',
      'cost' => 17700,
      'translations' => [
        Language::LOCALE_EN_US => 'Tashir',
        Language::LOCALE_HY_AM => 'Տաշիր',
        Language::LOCALE_RU_RU => 'Ташир',
      ],
    ],
    [
      'slug' => 'vayk',
      'cost' => 15500,
      'translations' => [
        Language::LOCALE_EN_US => 'Vayk',
        Language::LOCALE_HY_AM => 'Վայք',
        Language::LOCALE_RU_RU => 'Вайк',
      ],
    ],
    [
      'slug' => 'vahagni-district',
      'cost' => 1400,
      'translations' => [
        Language::LOCALE_EN_US => 'Vahagni district',
        Language::LOCALE_HY_AM => 'Վահագնի թաղամաս',
        Language::LOCALE_RU_RU => 'Ваагни район',
      ],
    ],
  ];
}
