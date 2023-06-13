<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccessoryRequest extends FormRequest
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
            'accessoryCategory' => 'required',
            'accessoryName' => 'required|max:255',
            'accessoryPrice' => 'required|numeric|gte:0',
            'accessoryDiscount_price' => 'exclude_if:accessoryDiscount_price,null|gte:0|lt:accessoryPrice|numeric',
            'accessoryVat' => 'required|integer|gte:0'
        ];
    }

    public function messages()
    {
        return [
            'accessoryCategory.required' => 'Een categorie selecteren is verplicht',
            'accessoryName.required' => 'Een naam invullen is verplicht',
            'accessoryName.max' => 'Een naam mag maximaal :max tekens bevatten',
            'accessoryPrice.required' => 'Een prijs invullen is verplicht',
            'accessoryPrice.numeric' => 'De prijs moet een getal zijn',
            'accessoryPrice.gte' => 'De prijs moet 0 of groter zijn',
            'accessoryDiscount_price.gte' => 'De kortingsprijs moet 0 of groter zijn',
            'accessoryDiscount_price.lt' => 'De kortingsprijs moet kleiner zijn dan de normale prijs',
            'accessoryDiscount_price.numeric' => 'De kortingsprijs moet een getal zijn',
            'accessoryVat.required' => 'De BTW invullen is verplicht',
            'accessoryVat.integer' => 'De BTW moet een volledig getal zijn',
            'accessoryVat.gte' => 'De BTW moet 0 of groter zijn',
        ];
    }
}
