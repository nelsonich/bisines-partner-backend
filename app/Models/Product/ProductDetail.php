<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'product_details';

  protected $fillable = ['product_id', 'product_field_id'];

  public function value()
  {
    return $this->hasMany(ProductDetailValue::class, 'product_detail_id', 'id');
  }
}
