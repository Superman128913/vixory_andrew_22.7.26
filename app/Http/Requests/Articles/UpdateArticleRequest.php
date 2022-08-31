<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'name'            => ['nullable', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'link'            => ['nullable', 'string', 'max:255'],
            'featured_image'  => ['nullable', 'string', 'max:255']
        ];
    }
}
