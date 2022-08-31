<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'name'            => ['required', 'string', 'max:255'],
            'description'     => ['required', 'string'],
            'link'            => ['required', 'string', 'max:255'],
            'featured_image'  => ['nullable', 'string', 'max:255']
        ];
    }
}
