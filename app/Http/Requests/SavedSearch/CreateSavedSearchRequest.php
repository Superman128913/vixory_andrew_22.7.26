<?php

namespace App\Http\Requests\SavedSearch;

use Illuminate\Foundation\Http\FormRequest;

class CreateSavedSearchRequest extends FormRequest
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
            "criteria"          => ["required", "json"],
            "sports"            => ["nullable", "json"]
        ];
    }
}
