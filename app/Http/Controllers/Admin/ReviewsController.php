<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
  /**
   * GET: /api/admin/reviews
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

  /**
   * POST: /api/admin/reviews
   */
  public function create(Request $request)
  {
    $authorImageKey = $request->post('author_image_key');
    $authorName = $request->post('author_name');
    $content = $request->post('content');
    $rate = $request->post('rate');

    $review = Review::create([
      'author_name' => $authorName,
      'author_image_key' => $authorImageKey,
      'content' => $content,
      'rate' => $rate,
    ]);

    return response()->json([
      'review' => $review,
      'status' => 'success',
    ]);
  }

  /**
   * DELETE: /api/admin/reviews/{id}
   */
  public function delete(Request $request, $id)
  {
    Review::destroy($id);

    return response()->json([
      'status' => 'success',
    ]);
  }
}
