<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProfileTheme extends Model
{
    public function sport()
    {
        return $this->belongsTo('App\Models\Sport');
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($profile_theme) 
        {
            Storage::disk("public")->delete($profile_theme->image);
        });
    }
}
