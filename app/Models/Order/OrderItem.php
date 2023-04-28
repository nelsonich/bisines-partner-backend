<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'order_items';

  protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'price',
    'total',
  ];

  public function product()
  {
    return $this->hasOne(Product::class, 'id', 'product_id');
  }
}
