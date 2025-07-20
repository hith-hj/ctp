<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                $product = $this->route()->product;

                return [
                    'name:en' => 'required|max:100',
                    // 'sku' => 'required|unique:products,sku,'.$product->id,
                    'price' => ['required', 'numeric'],
                    'capital_price' => ['required', 'numeric'],
                    'price_before_discount' => ['required', 'numeric'],
                    'featured_image' => 'required|image',
                    'category' => ['required', 'exists:categories,id'],
                ];
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name:en' => 'required|max:100',
                    // 'sku' => 'required',
                    'price' => ['required', 'numeric'],
                    'capital_price' => ['required', 'numeric'],
                    'price_before_discount' => ['required', 'numeric'],
                    'featured_image' => 'required|image',
                    'category' => ['required', 'exists:categories,id'],
                    'description:en' => ['nullable', 'string'],
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
            'sku.required' => 'SKU is required!',
            'images.required' => 'Product picture is required',
            'price.required' => 'Price is required!',
        ];
    }
}
