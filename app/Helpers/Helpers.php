<?php 

/**
 * Take an eloquent collection and convert it into an array of key/value pairs. The models
 * id is used as the value, and the key is whatever is specified by $key_name.
 */
function models_to_key_value($models, $key_name = "name")
{
    $kv_pairs = array();
    foreach($models as $model)
    {
        $kv_pairs[] = [
            'key'       => $model[$key_name],
            'value'     => $model['id']
        ];
    }
    return $kv_pairs;
}

/**
 * Return an array of all of the different sport positions.
 */
function sport_position_names()
{
    return array("baseball_positions", "basketball_position", "soccer_position", "football_offensive_position", "football_defensive_position");
}

/**
 * Return a list of admin users.
 */
function admin_users() 
{
    return \App\User::role('admin')->get();
}

/**
 * Accepts an emperical length FT"IN' and converts it into inches. Note that the quotes
 * have already been stripped from the string leaving just "FTIN".
 */
function convert_empirical_to_inches($empirical)
{
    if(is_null($empirical)) {
        return;
    }

    $feet = (int) $empirical[0];
    $inches = strlen($empirical) > 1 ? $empirical[1] : 0;

    $inches = 0;
    if(strlen($empirical) > 1) {
        $inches = substr($empirical, 1);
    }
    
    return $feet * 12 + $inches;
}

/**
 * Accepts inches as an integer and converts it into an empirical string FT"IN'
 */
function convert_inches_to_empirical($inches)
{
    return ((int)($inches / 12)) . (string) $inches % 12;
}