<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  /**
   * GET: /api/admin/users
   */
  public function getMany()
  {
    $users = User::query()
      ->where('role', User::ROLE_CUSTOMER)
      ->get();

    return response()->json([
      'users' => $users,
      'status' => 'success',
    ]);
  }
}
