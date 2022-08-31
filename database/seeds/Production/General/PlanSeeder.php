<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Delete all of the existing plans.
        $plans = Plan::all();
        foreach($plans as $plan)
        {
            $plan->delete();
        }

        //Import all of the plans from the csv.
        $csv = Reader::createFromPath(storage_path('docs/plans.csv'));
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) 
        {
            //Store the plans image
            if($record['image_name']) {
                $image_name = $record['image_name'];
                $image_path = $record['image_path'];
                Storage::disk('public')->put($image_name, $this->getImage($image_path));
            }

            //Create the plan
            $plan = new Plan();
            $plan->name = $record['plan_name'];
            $plan->description = $record['description'] ? $record['description'] : null;
            $plan->is_active = !($record['is_active'] == '0');
            $plan->cost = $record['plan_cost'] * 100;
            $plan->trial_duration = $record['trial_length'] ? $record['trial_length'] : 0;
            $plan->stripe_id = $record['stripe_id'];
            $plan->role = $record['role'];
            if(isset($image_name)) {
                $plan->plan_image = $image_name;
            }

            $plan->save();
        }
    }

    /**
     * Note: This function is also in AddCoverImages.php seeder. 
     */
    public function getImage($path)
    {
        //Don't verify cert
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        return file_get_contents(url($path), false, stream_context_create($arrContextOptions));
    }
}
