<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('isAdmin', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discountPrice' => 'exclude_if:discountPrice,null|numeric|gte:0',
            'quantity' => 'required|gt:0|lte:100|integer'
        ];
    }

    public function messages()
    {
        return [
            'discountPrice.numeric' => 'Korting moet een getal zijn en komma is "."',
            'discountPrice.gte' => 'Korting mag niet lager dan 0 zijn',
            'quantity.integer' => 'Aantal moet een volledig getal zijn',
            'quantity.gt' => 'Aantal mag niet lager dan 1 zijn',
            'quantity.required' => 'Aantal is verplicht',
            'quantity.lte' => 'Aantal mag niet hoger zijn dan 100'
        ];
    }
}
