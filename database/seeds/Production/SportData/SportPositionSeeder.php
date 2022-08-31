<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

use App\Models\Sport;
use App\Models\SportPosition;

class SportPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate the college table.
        SportPosition::truncate();

        //Import all of the colleges from the csv.
        $csv = Reader::createFromPath(storage_path('docs/positions.csv'));
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) 
        {
            $sport = Sport::where("name", $record["sport"])->first();
            if($sport)
            {
                $position = new SportPosition();
                $position->name = $record["name"];
                $position->key = $record["key"];
                $position->sport_id = $sport->id;
                $position->save();
            }
        }
    }
}
