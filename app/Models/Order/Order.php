<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;
  use HasUuids;

  const STATUS_PENDING = 'pending';
  const STATUS_PAID = 'paid';
  const STATUS_FAILED = 'failed';
  const STATUS_EXPIRED = 'expired';
  const STATUS_CANCELED = 'canceled';

  const STATUSES = [
    self::STATUS_PENDING,
    self::STATUS_PAID,
    self::STATUS_FAILED,
    self::STATUS_EXPIRED,
    self::STATUS_CANCELED,
  ];

  const PAYMENT_TYPE_CASH = 'cash';
  const PAYMENT_TYPE_IDRAM = 'idram';
  const PAYMENT_TYPE_CREDIT_CARD = 'credit_card';
  const PAYMENT_TYPE_CREDIT_WALLET = 'wallet';

  const PAYMENT_TYPES = [
    self::PAYMENT_TYPE_CASH,
    self::PAYMENT_TYPE_IDRAM,
    self::PAYMENT_TYPE_CREDIT_CARD,
    self::PAYMENT_TYPE_CREDIT_WALLET,
  ];

  protected $table = 'orders';

  protected $fillable = [
    'user_id',
    'code',
    'total',
    'status',
    'comment',
    'payment_type',
  ];

  public function recipient()
  {
    return $this->hasOne(OrderRecipient::class, 'order_id', 'id');
  }

  public function items()
  {
    return $this->hasMany(OrderItem::class, 'order_id', 'id');
  }
}
