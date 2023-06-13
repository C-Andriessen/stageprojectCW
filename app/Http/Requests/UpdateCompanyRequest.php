<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Een naam is verplicht.',
            'email.required' => 'Een email is verplicht.',
            'email.email' => 'Vul een geldig e-mailadres in',
            'address.required' => 'Een adres is verplicht',
            'zip_code.required' => 'Een postcode is verplicht',
            'city.required' => 'Een stad is verplicht',
            'phone_number.required' => 'Een telefoonnummer is verplicht',
            'phone_number.numeric' => 'Een telefoonnummer moet bestaan uit alleen nummers',
        ];
    }
}
