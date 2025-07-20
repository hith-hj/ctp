<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
            case 'PUT':
            case 'POST':
            case 'PATCH':
                $this->request->set('use_as_filter', $this->request->get('use_as_filter') == 'on' || $this->request->get('use_as_filter') == 1 ? '1' : '0'
                );

                return [
                    'name:en' => 'required|max:100',
                    'type' => 'required',
                ];
            case 'DELETE':
            case 'GET':
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
            'name:en.required' => 'Name in English is required!',
            'image.required' => 'Image is required!',
            'sort_order.required' => 'Sort Order is required!',
        ];
    }
}
