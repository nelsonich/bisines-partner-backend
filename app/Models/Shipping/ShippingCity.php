<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCity extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'shipping_cities';

  protected $fillable = ['cost', 'slug'];

  public function translation()
  {
    $language = request()->attributes->get('lang');
    return $this->hasOne(
      ShippingCityTranslation::class,
      'shipping_city_id',
      'id'
    )->where('language_id', $language->id);
  }

  public function translations()
  {
    return $this->hasMany(
      ShippingCityTranslation::class,
      'shipping_city_id',
      'id'
    );
  }
}
