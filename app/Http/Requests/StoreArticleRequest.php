<?php

namespace App\Http\Requests;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * 
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('createStore', Article::class);
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
            'introduction' => 'required|max:255',
            'content' => 'required|max:65000',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required|after:start_date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Een titel is verplicht.',
            'title.min' => 'De lengte van een titel moet tenminste 3 karakters lang zijn.',
            'title.max' => 'De titel mag niet langer zijn dan 200 karakters.',
            'introduction.required' => 'Een introductie is verplicht.',
            'introduction.max' => 'De introductie mag niet langer zijn dan 255 karakters.',
            'content.required' => 'Een artikel is verplicht',
            'content.max' => 'Het artikel mag niet langer zijn dan 65000 karakters.',
            'start_date.required' => 'Een start datum is verplicht',
            'start_date.before' => 'De start datum moet eerder zijn dan de eind datum',
            'end_date.required' => 'Een eind datum is verplicht',
            'end_date.after' => 'De eind datum moet later zijn dan de start datum'
        ];
    }
}
