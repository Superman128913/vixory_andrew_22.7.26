<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class ArticleListUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user= $this->route('user');

        if($user->show_info) {
            return true;
        }
        else {
            $authed_user = \Auth::user();
            if($authed_user->hasApprovedConnection($user->id)) {
                return true;
            }
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
