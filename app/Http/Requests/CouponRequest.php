<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'PUT':
            case 'PATCH':
            case 'POST':
                return [
                    'name:en' => 'required|max:100',
                    'code' => 'required|max:100|unique:coupons',
                    'coupon_value' => 'required',
                    'min_amount' => 'required',
                    'max_amount' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ];
            case 'DELETE':
                return [];
            default:break;
        }

        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
        ];
    }
}
