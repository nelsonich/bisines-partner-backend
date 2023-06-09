<?php

namespace App\Http\Requests\Profile\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class EditInfoRequest extends FormRequest
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
      'first_name' => 'required|string',
      'last_name' => 'required|string',
      'gender' => 'in:' . implode(',', User::GENDERS),
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
      // first_name
      'first_name.required' => 'auth_error_required_first_name',
      'first_name.string' => 'auth_error_invalid_first_name',

      // last_name
      'last_name.required' => 'auth_error_required_last_name',
      'last_name.string' => 'auth_error_invalid_last_name',
    ];
  }
}
