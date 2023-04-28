<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasFactory;
  use HasUuids;
  use SoftDeletes;
  use HasApiTokens;
  use Notifiable;

  const ROLE_ADMIN = 'admin';
  const ROLE_CUSTOMER = 'customer';

  const PROVIDER_STANDARD = 'standard';
  const PROVIDER_FACEBOOK = 'facebook';
  const PROVIDER_GOOGLE = 'google';

  const PROVIDERS = [
    self::PROVIDER_STANDARD,
    self::PROVIDER_FACEBOOK,
    self::PROVIDER_GOOGLE,
  ];

  const GENDER_MALE = 'male';
  const GENDER_FEMALE = 'female';

  const GENDERS = [self::GENDER_MALE, self::GENDER_FEMALE];

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'provider',
    'role',
    'verified_at',
    'first_name',
    'last_name',
    'email',
    'phone',
    'gender',
    'password',
    'facebook_id',
    'google_id',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ['password'];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
}
