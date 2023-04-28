<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  use HasFactory;
  use HasUuids;

  protected $table = 'reviews';

  protected $fillable = ['author_name', 'author_image_key', 'content', 'rate'];
}
