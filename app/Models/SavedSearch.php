<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Jobs\RunSavedSearch;

class SavedSearch extends Model
{
    protected $fillable = ['criteria', 'sports', 'user_id', 'day_of_the_week'];
    protected $dates = ['last_ran'];

    //Accessors and Mutators
    public function getSportsAttribute($value)
    {
        return json_decode($value);
    }

    public function getCriteriaAttribute($value)
    {
        $criteria = json_decode($value);
        if(isset($criteria->height_min))
        {
            $criteria->height_min = convert_inches_to_empirical($criteria->height_min);
        }
        if(isset($criteria->height_max))
        {
            $criteria->height_max = convert_inches_to_empirical($criteria->height_max);
        }
        return $criteria;
    }

    public function setCriteriaAttribute($value)
    {
        $criteria = json_decode($value);

        //Height modifier
        if(isset($criteria->height_min))
        {
            $criteria->height_min = convert_empirical_to_inches($criteria->height_min);
        }
        if(isset($criteria->height_max))
        {
            $criteria->height_max = convert_empirical_to_inches($criteria->height_max);
        }

        $this->attributes['criteria'] = json_encode($criteria);
    }

    public function getCriteriaCountAttribute($value)
    {
        //Remove the page attribute
        $criteria = $this->criteria;
        unset($criteria->page);

        //Remove the sports_selected attribute if its empty
        if(property_exists($criteria, "sports_selected") && count($criteria->sports_selected) < 1) {
            unset($criteria->sports_selected);
        }

        return count((array) $criteria);
    }

    //Relations
    public function user()
    {
        return $this->belongsTo("App\User");
    }

    //Model Events
    protected static function boot()
    {
        static::created(function ($saved_search) {
            //Run the saved search initially.
            RunSavedSearch::dispatch($saved_search, false);
        });
        parent::boot();
    }
}
