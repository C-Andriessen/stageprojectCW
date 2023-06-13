<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectsUsersRequest extends FormRequest
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
            "user" => 'required',
            "role" => 'required',
        ];
    }

    public function messages()
    {
        return [
            "user.required" => "Selecteer een gebruiker",
            "role.required" => "Selecteer een rol",
        ];
    }
}
