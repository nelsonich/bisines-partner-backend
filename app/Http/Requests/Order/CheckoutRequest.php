<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
    $rules = [
      'fullName' => 'required|string|min:3',
      'phone' => 'required|string|min:9|max:12',
      'total' => 'required',
      'city' => 'required',
      'address' => 'required',
      'date' => 'required',
      'time' => 'required',
    ];

    return $rules;
  }

  /**
   * Override validation messages.
   *
   * @return array<string, string>
   */
  public function messages()
  {
    return [
      'total.required' => 'checkout_error_required_total',
      'city.required' => 'checkout_error_required_city',

      'phone.required' => 'checkout_error_required_phone',
      'phone.min' => 'checkout_error_invalid_phone',
      'phone.max' => 'checkout_error_invalid_phone',

      'fullName.required' => 'checkout_error_required_fullName',
      'fullName.string' => 'checkout_error_invalid_fullName',
      'fullName.min' => 'checkout_error_invalid_fullName',

      'date.required' => 'checkout_error_required_date',
      'time.required' => 'checkout_error_required_time',
    ];
  }
}
