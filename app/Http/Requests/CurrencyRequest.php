<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            case 'PATCH':
            case 'DELETE':
                return [];
            case 'PUT':
            case 'POST':
                $this->request->set('use_api_rate', $this->request->get('use_api_rate') == 'on' || $this->request->get('use_api_rate') == 1 ? '1' : '0'
                );

                return [
                    'name:en' => 'required|max:100',
                    'rate' => 'required',
                    'symbol' => 'required',
                    'code' => 'required',
                ];
            default:break;
        }

        return [];
    }
}
