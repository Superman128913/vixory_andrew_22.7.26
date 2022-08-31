<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = ["user_id", "requested_user_id", "accepted", "requests_sent", "request_last_sent"];

    public function sender()
    {
        return $this->belongsTo("App\User", "user_id");
    }

    public function athlete()
    {
        return $this->belongsTo("App\User", "requested_user_id");
    }
}
