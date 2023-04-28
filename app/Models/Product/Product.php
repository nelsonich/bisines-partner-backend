<?php

namespace App\Models\Product;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory;
  use HasUuids;
  use SoftDeletes;

  protected $table = 'products';

  protected $fillable = ['category_id', 'price', 'image_key'];

  public function translation()
  {
    $language = request()->attributes->get('lang');
    return $this->hasOne(ProductTranslation::class, 'product_id', 'id')->where(
      'language_id',
      $language->id
    );
  }

  public function translations()
  {
    return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
  }

  public function category()
  {
    return $this->hasOne(Category::class, 'id', 'category_id');
  }

  public function images()
  {
    return $this->hasMany(ProductImage::class, 'product_id', 'id');
  }

  public function detail()
  {
    return $this->hasMany(ProductDetail::class, 'product_id', 'id');
  }
}
