<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\User\EditInfoRequest;
use App\Http\Requests\Profile\User\UpdateInfoRequest;

class ProfileController extends Controller
{
  /**
   * PUT: /api/users/profile
   */
  public function edit(EditInfoRequest $request)
  {
    $firsName = $request->post('first_name');
    $lastName = $request->post('last_name');
    $gender = $request->post('gender');

    $authId = auth()->id();
    $user = User::find($authId);
    $user->first_name = $firsName;
    $user->last_name = $lastName;
    $user->gender = $gender;
    $user->save();

    return response()->json([
      'status' => 'success',
      'message' => 'successfully_updated',
    ]);
  }

  /**
   * PATCH: /api/users/profile
   */
  public function update(UpdateInfoRequest $request)
  {
    if ($request->has('phone')) {
      $phone = $request->post('phone');

      $authId = auth()->id();
      $user = User::find($authId);
      $user->phone = $phone;
      $user->save();
    }

    return response()->json([
      'status' => 'success',
      'message' => 'successfully_updated',
    ]);
  }
}
