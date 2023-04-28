<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\User\GetMeRequest;
use App\Traits\AuthenticationTrait;

class UserController extends Controller
{
  use AuthenticationTrait;

  public function getMe(GetMeRequest $request)
  {
    return $this->mergeLoginData(auth()->user());
  }
}
