<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportPosition extends Model
{
    public function sport()
    {
        return $this->belongsTo("App\Models\Sport");
    }

    public function users()
    {
        return $this->belongsToMany("App\User");
    }
}
