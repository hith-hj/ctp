<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
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
                    'service_id' => 'required|exists:services,id',
                    'review' => ['required', Rule::in([1, 2, 3, 4, 5, '1', '2', '3', '4', '5'])],
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
            'service_id.exists' => 'We could not find any service match your request',
        ];
    }
}
