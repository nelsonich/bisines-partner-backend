<?php

namespace App\Traits;

trait SlugifyTrait
{
  private $slugifyRussian = [
    'а' => 'a',
    'б' => 'b',
    'в' => 'v',
    'г' => 'g',
    'д' => 'd',
    'е' => 'e',
    'ё' => 'io',
    'ж' => 'zh',
    'з' => 'z',
    'и' => 'i',
    'й' => 'y',
    'к' => 'k',
    'л' => 'l',
    'м' => 'm',
    'н' => 'n',
    'о' => 'o',
    'п' => 'p',
    'р' => 'r',
    'с' => 's',
    'т' => 't',
    'у' => 'u',
    'ф' => 'f',
    'х' => 'h',
    'ц' => 'ts',
    'ч' => 'ch',
    'ш' => 'sh',
    'щ' => 'sht',
    'ъ' => 'a',
    'ы' => 'i',
    'ь' => 'y',
    'э' => 'e',
    'ю' => 'yu',
    'я' => 'ya',
  ];

  private $slugifyArmenian = [
    'ա' => 'a',
    'ի' => 'i',
    'յ' => 'y',
    'տ' => 't',
    'բ' => 'b',
    'լ' => 'l',
    'ն' => 'n',
    'ր' => 'r',
    'գ' => 'g',
    'խ' => 'x',
    'շ' => 'sh',
    'ց' => 'c',
    'դ' => 'd',
    'ծ' => 'c',
    'ո' => 'o',
    'ւ' => 'w',
    'ե' => 'e',
    'կ' => 'k',
    'չ' => 'ch',
    'փ' => 'p',
    'զ' => 'z',
    'հ' => 'h',
    'պ' => 'p',
    'ք' => 'q',
    'է' => 'e',
    'ձ' => 'd',
    'ջ' => 'j',
    'օ' => 'o',
    'ը' => 'y',
    'ղ' => 'gh',
    'ռ' => 'r',
    'ֆ' => 'f',
    'թ' => 't',
    'ճ' => 'tw',
    'ս' => 's',
    'ու' => 'u',
    'ժ' => 'jh',
    'մ' => 'm',
    'վ' => 'v',
    'և' => 'ev',
  ];

  private function slugify($value)
  {
    $updated = mb_strtolower(strtolower($value));
    $updated = str_replace(' ', '-', $updated);
    $updated = preg_replace('#[\s\t\n,\_]#', '-', $updated);
    $updated = preg_replace('#\-{2,}#', '-', $updated);
    $updated = strtr($updated, $this->slugifyRussian);
    $updated = strtr($updated, $this->slugifyArmenian);

    return $updated;
  }
}
