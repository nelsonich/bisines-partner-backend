<?php

namespace App\Models\Product;

use App\Models\Language;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'product_translations';

  protected $fillable = [
    'product_id',
    'language_id',
    'title',
    'description',
    'slug',
  ];

  public function language()
  {
    return $this->hasOne(Language::class, 'id', 'language_id');
  }
}
