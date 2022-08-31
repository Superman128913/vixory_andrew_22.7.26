<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use BenSampo\Enum\Traits\CastsEnums;
use App\Enums\SchoolDivision;
use App\Enums\SchoolType;
use App\Enums\StateCode;

class College extends Model
{
    use CastsEnums, Searchable;

    protected $enumCasts = [
        'state_code' => StateCode::class,
        'division' => SchoolDivision::class,
        'type' => SchoolType::class,
    ];

    protected $casts = [
        'state_code' => 'int',
        'division' => 'int',
        'type' => 'int'
    ];

    protected $appends = [
        'state_name'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            "name" => $this->name,
            "city" => $this->city,
            "domain" => $this->domain
        ];
    }

    //Relations
    public function users()
    {
        return $this->hasMany('App\User');
    }

    //Accessors & Mutators
    public function getStateNameAttribute()
    {
        if(isset($this->state_code->key)) 
        {
            return $this->state_code->key;
        }
    }
}
