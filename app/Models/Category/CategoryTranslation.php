<?php

namespace App\Models\Category;

use App\Models\Language;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'category_translations';

  protected $fillable = ['category_id', 'language_id', 'title'];

  public function language()
  {
    return $this->hasOne(Language::class, 'id', 'language_id');
  }
}
