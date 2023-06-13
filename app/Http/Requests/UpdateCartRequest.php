<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|gt:0|lte:100|integer',
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'Aantal mag niet leeg zijn',
            'quantity.gt' => 'Aantal moet meer zijn dan 0',
            'quantity.integer' => 'Aantal moet een volledig getal zijn',
            'quantity.lte' => 'Aantal mag niet meer dan 100 zijn'
        ];
    }
}
