<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                $parentCategory = $this->request->get('parent_category');
                $this->request->set('parent_category', $parentCategory == '0' || $parentCategory == 0 ? null : $parentCategory
                );

                return [
                    'name:en' => 'required|max:100',
                    'sort_order' => 'required',
                ];
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name:en' => 'required|max:100',
                    'sort_order' => 'required',
                    // 'image' => 'required',
                    'image' => 'nullable',
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
            'name:en.required' => 'Name in English is required!',
            // 'image.required'  => 'Image is required!',
            'sort_order.required' => 'Sort Order is required!',
        ];
    }
}
