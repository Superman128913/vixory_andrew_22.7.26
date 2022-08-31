<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use BenSampo\Enum\Traits\CastsEnums;
use App\Enums\FieldType;

class SportField extends Model
{
    use CastsEnums;

    protected $enumCasts = [
        'type' => FieldType::class,
        'filter_type' => FieldType::class,
    ];

    protected $casts = [
        'type' => 'int',
        'filter_type' => 'int',
    ];

    public function sport()
    {
        return $this->belongsTo('App\Models\Sport');
    }
}
