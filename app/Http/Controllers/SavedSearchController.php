<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SavedSearch\ListSavedSearchRequest;
use App\Http\Requests\SavedSearch\CreateSavedSearchRequest;
use App\Http\Requests\SavedSearch\UpdateSavedSearchRequest;
use App\Http\Requests\SavedSearch\DeleteSavedSearchRequest;

use App\User;
use App\Models\SavedSearch;

class SavedSearchController extends Controller
{
    public function getSingle(Request $request, SavedSearch $saved_search)
    {
        return response()->json($saved_search, 200);
    }

    /**
     * List all of the users saved searches.
     */
    public function list(ListSavedSearchRequest $request)
    {
        $request->validated();

        $user = \Auth::user();
        $saved_searches = $user->savedsearches;
        
        return response()->json($saved_searches, 200);
    }

    /**
     * Create a new saved search.
     */
    public function create(CreateSavedSearchRequest $request)
    {
        $fields = $request->validated();

        //Remove any known properties that are not criteria.
        unset($fields["search_across_sports"]);

        //Remove any properties that shouldn't be in criteria.
        $criteria = json_decode($fields["criteria"]);
        unset($criteria->page);
        
        $day_of_week = date('N');
        $user = \Auth::user();

        $saved_search = SavedSearch::create([
            "user_id"           => $user->id,
            "criteria"          => json_encode($criteria),
            "sports"            => $fields["sports"],
            "day_of_the_week"   => $day_of_week
        ]);
    }

    /**
     * Update an existing saved search.
     */
    public function update(UpdateSavedSearchRequest $request, SavedSearch $saved_search)
    {
        $fields = $request->validated();
        $saved_search->update($fields);

        return response()->json($saved_search, 200);
    }
    
    /**
     * Delete an existing saved search.
     */
    public function delete(DeleteSavedSearchRequest $request, SavedSearch $saved_search)
    {
        $request->validated();

        $saved_search->delete();
        return response()->json($saved_search, 200);
    }
}
