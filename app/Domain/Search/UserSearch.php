<?php 
namespace App\Domain\Search;

use App\User;

class UserSearch
{
    protected $user; //The user performing the query.
    protected $query;

    public function __construct($user_id)
    {
        $this->user = User::find($user_id);
        $this->query = User::query();
        $this->query->where("is_deactivated", false);
        $this->query->whereNotNull("age"); //Used to filter out users who have never saved their profile after registration
        $this->preventCollegeOverlap();
    }

    /**
     * Prevent coaches from seeing athletes who go to their college. This function checks whether
     * the user has a college so that pro scouts are able to search normally.
     */
    public function preventCollegeOverlap()
    {
        $this->user->load("college");
        if($this->user->college) 
        {
            $college_id = $this->user->college->id;
            $this->query->whereDoesntHave('college', function($q) use($college_id) {
                $q->where("id", "=", $college_id);
            });
        }
    }

    /**
     * Refine the sports that this query can match.
     */
    public function refineSports($ids)
    {
        $this->query->whereHas('sports', function($q) use($ids) {
            $q->whereIn('sports.id', $ids);
        });
    }

    /**
     * 
     */
    public function refineSportPosition($id)
    {
        $this->query->whereHas('sportpositions', function($q) use($id) {
            $q->where('id', '=', $id);
        });
    }

    /**
     * Add criteria by passing in an object where each property name/value corresponds
     * to a criterions name/value.
     */
    public function addCriteria($criteria)
    {
        foreach($criteria as $key => $value)
        {
            $this->addCriterion($key, $value);
        }
    }

    /**
     * Add an individual criterion to the query.
     */
    public function addCriterion($name, $value)
    {
        //Make sure the value isn't empty
        if($value === "" || $value === null){
            return false;
        }

        //Perform any need value manipulation
        $value = $this->value_processing($name, $value);

        //Process criterion based on it's modifier (_min, _max, etc).
        $max_count = 0;
        $min_count = 0;

        $name = preg_replace("/_min/", "", $name, -1, $min_count);
        if($min_count > 0) {
            $this->query->where($name, ">=", $value);
        }
        else 
        {
            $name = preg_replace("/_max/", "", $name, -1, $max_count);
            if($max_count > 0)
            {
                
                if($max_count > 0) {
                    $this->query->where($name, "<=", $value);
                }
            }
        }

        //If modifier isn't present and value isn't an array.
        if($max_count === 0 && $min_count === 0 && ! is_array($value)) {
            //Search fields
            if(in_array($name, array("highschool", "hometown", "city"))) {
                $this->query->where($name, 'like', '%' . $value . '%');
            }

            //Standard equality check
            else {
                $this->query->where($name, "=", $value);
            }
        }

        //If value is an array and the name is "sports".
        elseif(is_array($value) && $name === "sports") {
            $this->refineSports($value);
        }
    }

    /**
     * Wrapper function around eloquents paginate method.
     */
    public function paginate()
    {
        return $this->query->paginate(100);
    }

    /**
     * Perform any sort of value level processing. e.g. convert the height string to inches in the same
     * way that the user setter does when saving the value.
     */
    public function value_processing($key, $value)
    {
        switch($key)
        {
            case "height_min":
                return convert_empirical_to_inches($value);
            case "height_max":
                return convert_empirical_to_inches($value);
            default:
                return $value;
        }
    }


    /**
     * Wrapper function around eloquents get method.
     */
    public function get()
    {
        return $this->query->with('college')->get();
    }

    /** 
     * Wrapper function around eloquents count method.
     */
    public function count()
    {
        return $this->query->count();
    }
}