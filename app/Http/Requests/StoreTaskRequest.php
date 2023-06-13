<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|min:3|max:80',
            'description' => 'required|max:65000',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required|after:start_date',
            "user" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Een titel is verplicht.',
            'title.min' => 'De lengte van een titel moet tenminste 3 karakters lang zijn.',
            'title.max' => 'De titel mag niet langer zijn dan 200 karakters.',
            'description.required' => 'Een omschrijving is verplicht',
            'description.max' => 'De omschrijving mag niet langer zijn dan 65000 karakters.',
            'start_date.required' => 'Een start datum is verplicht',
            'start_date.before' => 'De start datum moet eerder zijn dan de eind datum',
            'end_date.required' => 'Een eind datum is verplicht',
            'end_date.after' => 'De eind datum moet later zijn dan de start datum',
            "user.required" => "Selecteer een gebruiker",
        ];
    }
}
