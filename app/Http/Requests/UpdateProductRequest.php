<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'required|max:65000',
            'price_excl' => 'required|numeric|lte:99999999',
            'vat' => 'required|numeric|lte:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_price' => 'exclude_if:discount_price,null|gte:0|lt:price_excl|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product naam mag niet leeg zijn',
            'name.max' => 'Product naam mag niet langer zijn dan :max karakters',
            'description.required' => 'Product beschrijving mag niet leeg zijn',
            'description.max' => 'Product beschrijving mag niet langer zijn dan :max karakters',
            'price_excl.required' => 'Prijs is verplicht',
            'price_excl.numeric' => 'Prijs mag alleen bestaan uit nummers en een "."',
            'vat.required' => 'BTW is verplicht',
            'vat.numeric' => 'Prijs mag alleen bestaan uit nummers en een "."',
            'image.uploaded' => 'Het bestand is te groot, hij mag niet groter zijn dan 2MB',
            'image.image' => 'Het bestand moet een afbeelding zijn',
            'image.mimes' => 'De afbeelding moet een type hebben van: :values',
            'discount_price.gte' => 'Het kortingsbedrag mag niet lager dan 0 zijn',
            'discount_price.lt' => 'De korting moet lager zijn dan het prijs exclusief bedrag',
            'price_excl.gt' => 'Prijs moet hoger zijn dan het kortings bedrag',
            'discount.numeric' => 'Het kortingsbedrag moet een getal zijn, de komma is een "."',
            'price_excl.lte' => 'Prijs mag niet hoger zijn dan 99999999',
            'vat.lte' => 'BTW mag niet hoger zijn dan 100%',
        ];
    }
}
