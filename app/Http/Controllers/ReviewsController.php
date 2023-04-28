<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
  /**
   * GET: /api/reviews
   */
  public function getMany()
  {
    $reviews = Review::query()
      ->orderBy('id', 'desc')
      ->get();

    $mapped = [];
    foreach ($reviews as $review) {
      $item = [
        'id' => $review->id,
        'author_image_key' => $review->author_image_key,
        'author_name' => $review->author_name,
        'content' => $review->content,
        'rate' => $review->rate,
      ];

      $mapped[] = $item;
    }

    return response()->json([
      'reviews' => $mapped,
      'status' => 'success',
    ]);
  }
}
