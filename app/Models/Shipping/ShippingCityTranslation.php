<?php

namespace App\Models\Shipping;

use App\Models\Language;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCityTranslation extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'shipping_city_translations';

  protected $fillable = ['shipping_city_id', 'language_id', 'name'];

  public function language()
  {
    return $this->hasOne(Language::class, 'id', 'language_id');
  }
}
