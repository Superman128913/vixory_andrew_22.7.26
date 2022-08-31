<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'source_id'];

    //Relations
    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
