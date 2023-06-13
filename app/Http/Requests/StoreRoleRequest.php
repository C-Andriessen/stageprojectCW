<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|min:3|max:20'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Een naam is verplicht',
            'name.min' => 'De naam mag niet kleiner zijn dan :min tekens',
            'name.max' => 'De naam mag niet groter zijn dan :max tekens',
        ];
    }
}
