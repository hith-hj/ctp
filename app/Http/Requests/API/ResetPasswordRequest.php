<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'phone_number' => 'required',
                    'old_password' => 'required',
                    'new_password' => 'required|confirmed|min:6',
                ];
            default:break;
        }

        return [];
    }
}
