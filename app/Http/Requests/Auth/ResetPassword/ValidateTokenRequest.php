<?php

namespace App\Http\Requests\Auth\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTokenRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'reset_token' => 'required|string',
    ];
  }

  /**
   * Override validation messages.
   *
   * @return array<string, string>
   */
  public function messages()
  {
    return [
      // reset_token
      'reset_token.required' => 'auth_error_required_reset_token',
      'reset_token.string' => 'auth_error_invalid_reset_token',
    ];
  }
}
