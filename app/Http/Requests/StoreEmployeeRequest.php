<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'employee_name' => 'required',
            'employee_phone' => 'required|numeric',
            'employee_email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'employee_name.required' => 'Een naam is verplicht.',
            'employee_email.required' => 'Een email is verplicht.',
            'employee_email.email' => 'Vul een geldig e-mailadres in',
            'employee_phone.required' => 'Een telefoonnummer is verplicht',
            'employee_phone.numeric' => 'Een telefoonnummer moet bestaan uit alleen nummers',
        ];
    }
}
