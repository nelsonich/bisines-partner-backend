<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use HasFactory;
  use HasUuids;
  use SoftDeletes;

  const KEY_FLOWERS = 'flowers';
  const KEY_GIFTS = 'gifts';
  const KEY_TALKING_WINES = 'talking-wines';
  const KEY_WEDDING_ACCESSORIES = 'wedding-accessories';

  const KEYS = [
    self::KEY_FLOWERS,
    self::KEY_GIFTS,
    self::KEY_TALKING_WINES,
    self::KEY_WEDDING_ACCESSORIES,
  ];

  protected $table = 'categories';

  protected $fillable = ['key', 'image_key'];

  public function translation()
  {
    $language = request()->attributes->get('lang');
    return $this->hasOne(
      CategoryTranslation::class,
      'category_id',
      'id'
    )->where('language_id', $language->id);
  }

  public function translations()
  {
    return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
  }
}
