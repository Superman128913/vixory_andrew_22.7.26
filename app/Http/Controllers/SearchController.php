<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Searches\SearchUsersRequest;
use App\User;
use App\Domain\Search\UserSearch;

class SearchController extends Controller
{
    public function searchUsers(SearchUsersRequest $request)
    {
        //Setup the query data
        $fields = $request->validated();
        $fields = $this->removeFiltersFromUnselected($fields);

        //Setup the query
        $search = new UserSearch(\Auth::user()->id);

        //Filter users based on the selected sports
        $sportIds = $fields["sports_selected"];
        if($sportIds)
        {
            $search->refineSports($sportIds);
        }
        unset($fields["sports_selected"]);

        //Filter users sports positions
        foreach($fields as $field_key => $field_value)
        {
            if(in_array($field_key , sport_position_names())) 
            {
                $search->refineSportPosition($field_value);
                unset($fields[$field_key]);
            }
        }

        //Add the remaining criteria.
        $search->addCriteria($fields);

        //Execute the query
        $users = $search->paginate();

        //Hide user information as neccesary 
        foreach($users as $user)
        {
            if(! $user->show_info) {
                $user->hideContactInfo();
            }
        }

        return response()->json($users, 200);
    }

    /**
     * Remove filters which belong to sports that are not selected.
     */
    private function removeFiltersFromUnselected($fields)
    {
        return $fields;
    }
}
