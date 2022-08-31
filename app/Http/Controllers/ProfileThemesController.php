<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Themes\SetProfileThemeRequest;

use App\Models\User;
use App\Models\ProfileTheme;

class ProfileThemesController extends Controller
{
    public function get()
    {
        $themes = ProfileTheme::whereHas('sport', function($q){
            $q->where("is_active", true);
        })->get();
        return response()->json($themes, 200);
    }

    public function getSingle(Request $request, ProfileTheme $theme)
    {
        return response()->json($theme, 200);
    }

    public function setUserTheme(SetProfileThemeRequest $request, User $user)
    {
        $fields = $request->validated();
        $user->profile_theme_id = $fields["profile_theme_id"];
        $user->save();

        return response()->json($user, 200);
    }
}
