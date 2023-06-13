<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccessoryRequest extends FormRequest
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
            'category' . request()->id => 'required',
            'name' . request()->id => 'required|max:255',
            'price' . request()->id => 'required|numeric|gte:0',
            'discount_price' . request()->id => 'exclude_if:discount_price' . request()->id . ',null|gte:0|lt:accessoryPrice|numeric',
            'vat' . request()->id => 'required|integer|gte:0'
        ];
    }

    public function messages()
    {
        return [
            'category' . request()->id . '.required' => 'Een categorie selecteren is verplicht',
            'name' . request()->id . '.required' => 'Een naam invullen is verplicht',
            'name' . request()->id . '.max' => 'Een naam mag maximaal :max tekens bevatten',
            'price' . request()->id . '.required' => 'Een prijs invullen is verplicht',
            'price' . request()->id . '.numeric' => 'De prijs moet een getal zijn',
            'price' . request()->id . '.gte' => 'De prijs moet 0 of groter zijn',
            'discount_price' . request()->id . '.gte' => 'De kortingsprijs moet 0 of groter zijn',
            'discount_price' . request()->id . '.lt' => 'De kortingsprijs moet kleiner zijn dan de normale prijs',
            'discount_price' . request()->id . '.numeric' => 'De kortingsprijs moet een getal zijn',
            'vat' . request()->id . '.required' => 'De BTW invullen is verplicht',
            'vat' . request()->id . '.integer' => 'De BTW moet een volledig getal zijn',
            'vat' . request()->id . '.gte' => 'De BTW moet 0 of groter zijn',
        ];
    }
}
