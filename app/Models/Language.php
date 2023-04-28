<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
  use HasFactory;
  use HasUuids;

  const LOCALE_HY_AM = 'hy-am';
  const LOCALE_EN_US = 'en-us';
  const LOCALE_RU_RU = 'ru-ru';

  const ALL_KEYS = [self::LOCALE_HY_AM, self::LOCALE_EN_US, self::LOCALE_RU_RU];

  protected $table = 'languages';

  protected $fillable = ['locale'];
}
