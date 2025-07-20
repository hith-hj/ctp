<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                return [
                    // 'title:en' => 'required|max:100',
                    'sort_order' => 'required',
                ];
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    // 'title:en' => 'required|max:100',
                    'sort_order' => 'required',
                    'background_image' => 'required|image',
                    'responsive_image' => 'required|image',
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
            'title.required' => 'Title in English is required!',
            'image.required' => 'Image is required!',
            'sort_order.required' => 'Sort Order is required!',
        ];
    }
}
