<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordConfirmRequest extends FormRequest
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
            case 'POST':
                return [
                    'phone_number' => 'required|exists:users',
                    'password' => 'required|min:6|confirmed',
                    'reset_token' => 'required',
                ];
            default:break;
        }

        return [];
    }
}
