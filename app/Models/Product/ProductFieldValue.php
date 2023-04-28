<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFieldValue extends Model
{
  use HasFactory;
  use HasUuids;

  const COLOR_RED = 'red';
  const COLOR_GREEN = 'green';
  const COLOR_PINK = 'pink';
  const COLOR_BLUE = 'blue';
  const COLOR_YELLOW = 'yellow';

  const COLORS = [
    self::COLOR_RED,
    self::COLOR_GREEN,
    self::COLOR_PINK,
    self::COLOR_BLUE,
    self::COLOR_YELLOW,
  ];

  const CONTAINER_CART = 'cart';
  const CONTAINER_BOX = 'box';
  const CONTAINER_WOODEN_BOX = 'wooden_box';

  const CONTAINERS = [
    self::CONTAINER_CART,
    self::CONTAINER_BOX,
    self::CONTAINER_WOODEN_BOX,
  ];

  const TYPE_COMPOSITION_SWEETS = 'composition_sweets';
  const TYPE_A_BUNCH = 'a_bunch';
  const TYPE_BY_PIECE = 'by_piece';
  const TYPE_COMPOSITION = 'composition';

  const TYPES = [
    self::TYPE_COMPOSITION_SWEETS,
    self::TYPE_A_BUNCH,
    self::TYPE_BY_PIECE,
    self::TYPE_COMPOSITION,
  ];

  protected $table = 'product_field_values';

  protected $fillable = ['product_field_id', 'key'];

  public function translation()
  {
    $language = request()->attributes->get('lang');
    return $this->hasOne(
      ProductFieldValueTranslation::class,
      'product_field_value_id',
      'id'
    )->where('language_id', $language->id);
  }

  public function translations()
  {
    return $this->hasMany(
      ProductFieldValueTranslation::class,
      'product_field_value_id',
      'id'
    );
  }
}
