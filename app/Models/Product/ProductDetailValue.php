<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailValue extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'product_detail_values';

  protected $fillable = [
    'product_id',
    'product_detail_id',
    'product_field_id',
    'product_field_value_id',
  ];
}
