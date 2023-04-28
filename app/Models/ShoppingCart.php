<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'shopping_carts';

  protected $fillable = ['user_id', 'product_id', 'quantity'];

  public function product()
  {
    return $this->hasOne(Product::class, 'id', 'product_id');
  }
}
