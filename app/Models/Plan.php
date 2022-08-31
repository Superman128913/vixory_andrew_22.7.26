<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Plan extends Model
{
    public $casts = [
        'featured_list' => 'array'
    ];

    public static function boot() {
        parent::boot();
        self::deleting(function($plan) 
        {
            Storage::disk("public")->delete($plan->plan_image);
        });
    }
}
