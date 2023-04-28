<?php

namespace App\Models\Product;

use App\Models\Language;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFieldTranslation extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'product_field_translations';

  protected $fillable = ['product_field_id', 'language_id', 'title'];

  public function language()
  {
    return $this->hasOne(Language::class, 'id', 'language_id');
  }
}
