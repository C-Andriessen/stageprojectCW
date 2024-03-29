<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' . request()->id => 'required|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name' . request()->id . '.required' => 'Een naam invullen is verplicht',
            'name' . request()->id . '.max' => 'Een naam mag maximaal :max tekens bevatten',
        ];
    }
}
