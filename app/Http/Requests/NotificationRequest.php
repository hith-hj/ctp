<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            case 'DELETE':
            case 'PATCH':
                return [
                ];
            case 'POST':
                return [
                    'title:en' => 'required|max:100',
                    'message:en' => 'required',
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
            'title:en.required' => 'Notification title in English is required!',
            'title:ar.required' => 'Notification title in Arabic is required!',
        ];
    }
}
