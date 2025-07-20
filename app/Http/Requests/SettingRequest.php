<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
                    'type' => 'required',
                    'key' => 'required|max:255|unique:settings',
                ];
            case 'PUT':
            case 'PATCH':
                $setting = $this->route()->setting;

                return [
                    'type' => 'required',
                    'key' => 'required|max:255|unique:settings,key,'.$setting->id,
                ];
            default:break;
        }

        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type.required' => 'The settings type is required',
            'key.required' => 'The settings key is required',
            'key.unique' => 'The settings key should be unique',
        ];
    }
}
