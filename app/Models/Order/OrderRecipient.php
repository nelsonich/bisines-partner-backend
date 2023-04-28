<?php

namespace App\Models\Order;

use App\Models\Shipping\ShippingCity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRecipient extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'order_recipients';

  protected $fillable = [
    'order_id',

    'full_name',
    'phone',

    'city_id', // shipping cities
    'shipping_cost',

    'address',
    'house',
    'access',
    'floor',
    'intercom',

    'date',
    'time',
  ];

  public function city()
  {
    return $this->hasOne(ShippingCity::class, 'id', 'city_id');
  }
}
