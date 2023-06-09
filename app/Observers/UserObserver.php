<?php

namespace App\Observers;

use App\Contracts\Models\BaseModelObserver;
use App\Models\User;
use App\Models\VerifyEmail;

class UserObserver extends BaseModelObserver
{
  protected static function model()
  {
    return User::class;
  }

  /**
   * Handle the User "created" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function created(User $user)
  {
    // if is standard user and not generated by seeder,
    // then we need to verify email address.
    if (
      $user->provider == User::PROVIDER_STANDARD &&
      is_null($user->verified_at)
    ) {
      $verifyEmail = new VerifyEmail();
      $verifyEmail->user_id = $user->id;
      $verifyEmail->save();
    }
  }

  /**
   * Handle the User "updated" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function updated(User $user)
  {
    //
  }

  /**
   * Handle the User "deleted" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function deleted(User $user)
  {
    //
  }

  /**
   * Handle the User "restored" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function restored(User $user)
  {
    //
  }

  /**
   * Handle the User "force deleted" event.
   *
   * @param  \App\Models\User  $user
   * @return void
   */
  public function forceDeleted(User $user)
  {
    //
  }
}
