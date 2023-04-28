<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailValueTranslation extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'product_detail_value_translations';

  protected $fillable = ['product_detail_value_id', 'language_id', 'title'];
}
