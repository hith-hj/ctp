<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'first_name' => 'required|max:100',
                    'last_name' => 'required|max:100',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|confirmed|min:6',
                    //                    'city_id' => 'required',
                    'phone_number' => 'required|unique:users,phone_number',
                ];
            case 'PUT':
            case 'PATCH':
                $user = $this->route()->user;

                return [
                    'first_name' => 'required|max:100',
                    'last_name' => 'required|max:100',
                    //                    'city_id' => 'required',
                    'email' => 'email|unique:users,email,'.$user->id,
                    'phone_number' => 'required|unique:users,phone_number,'.$user->id,
                    'password' => 'nullable|confirmed|min:6',
                ];
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
            'email.unique' => 'email address has already been taken',
            'email.email' => 'please enter a valid email address',
            'first_name.required' => 'first name is required',
        ];
    }
}
