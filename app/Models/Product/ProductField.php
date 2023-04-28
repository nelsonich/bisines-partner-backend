<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductField extends Model
{
  use HasFactory;
  use HasUuids;

  const TYPE_INPUT = 'input';
  const TYPE_SINGLE = 'single';
  const TYPE_GROUP = 'group';

  const TYPES = [self::TYPE_INPUT, self::TYPE_SINGLE, self::TYPE_GROUP];

  protected $table = 'product_fields';

  protected $fillable = ['category_id', 'key', 'type'];

  public function values()
  {
    return $this->hasMany(ProductFieldValue::class);
  }

  public function translation()
  {
    $language = request()->attributes->get('lang');
    return $this->hasOne(
      ProductFieldTranslation::class,
      'product_field_id',
      'id'
    )->where('language_id', $language->id);
  }

  public function translations()
  {
    return $this->hasMany(
      ProductFieldTranslation::class,
      'product_field_id',
      'id'
    );
  }
}
