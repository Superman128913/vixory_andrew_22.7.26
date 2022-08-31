<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Domain\Search\UserSearch;
use App\Notifications\SavedSearchResults;

class RunSavedSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $saved_search;
    protected $notify;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($saved_search, $notify = true)
    {
        $this->saved_search = $saved_search;
        $this->notify = $notify;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Run the saved search
        $criteria = $this->saved_search->criteria;

        //Query the database
        $search = new UserSearch($this->saved_search->user_id);

        //Filter users based on the selected sports
        $selected_sports = $criteria->sports_selected;
        if($selected_sports)
        {
            $search->refineSports($selected_sports);
        }
        unset($criteria->sports_selected);
        
        //Filter users sports positions
        foreach($criteria as $field_key => $field_value)
        {
            if(in_array($field_key , sport_position_names())) 
            {
                $search->refineSportPosition($field_value);
                unset($criteria->{$field_key});
            }
        }

        //Add remaining search criteria
        $search->addCriteria($criteria);
        $new_users = $search->count();

        //Update the saved search
        if($this->saved_search->recent_count)
        {
            $this->saved_search->previous_count = $this->saved_search->recent_count;
        }
        $this->saved_search->recent_count = $new_users;
        $this->saved_search->last_ran = now();
        $this->saved_search->save();
        
        //Notify the user if additional users were found and this isn't the first run.
        $new_user_count = $this->saved_search->recent_count - $this->saved_search->previous_count;
        if($new_user_count > 0 && $this->notify) 
        {
            $this->saved_search->user->notify(new SavedSearchResults($this->saved_search, $new_user_count));
        }
    }
}
