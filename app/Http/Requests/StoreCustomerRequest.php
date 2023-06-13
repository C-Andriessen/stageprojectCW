<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            "name" => 'required',
            "email" => 'required|email',
            "address" => 'required',
            "city" => 'required',
            "zip_code" => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Naam is verplicht',
            'email.required' => 'Email is verplicht',
            'email.email' => 'Voer een echte email in',
            'address.required' => 'Adres is verplicht',
            'city.required' => 'Stad is verplicht',
            'zip_code.required' => 'Postcode is verplicht',
        ];
    }
}
