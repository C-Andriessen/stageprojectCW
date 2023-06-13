<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
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
            'quantity.required' => 'Aantal invullen is verplicht',
            'quantity.gt' => 'Aantal moet meer zijn dan 0',
            'quantity.lte' => 'Aantal mag niet hoger zijn dan 100',
            'quantity.integer' => 'Aantal moet een volledig nummer zijn',
        ];
    }
}
