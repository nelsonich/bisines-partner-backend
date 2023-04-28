<?php

namespace App\Http\Controllers;

use App\Cacheable\Http\ResponseCachable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Cache response by request.
   */
  final protected function cachable(
    Request $request,
    int $timeout,
    callable $callback
  ) {
    $cached = ResponseCachable::factory()
      ->setRequest($request)
      ->setTimeout($timeout)
      ->executeWithCallback($callback);

    $body = $cached->getResponse();
    $headers = $cached->getHeaders();

    return response()->json($body, 200, $headers);
  }
}
