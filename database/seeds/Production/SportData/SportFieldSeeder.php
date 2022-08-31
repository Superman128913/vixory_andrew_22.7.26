<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

use App\Models\Sport;
use App\Models\SportField;
use App\Models\SportPosition;

class SportFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate the college table.
        SportField::truncate();

        //Import all of the colleges from the csv.
        $csv = Reader::createFromPath(storage_path('docs/fields.csv'));
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) 
        {
            $sport = Sport::where("name", $record["sport"])->firstOrFail();

            $field = new SportField();
            $field->sport_id = $sport->id;
            $field->pretty_name = $record["pretty_name"];
            $field->table_name = $record["table_name"];
            $field->search_visible = !($record['search_visible'] == '0');
            $field->mask = $record["mask"];
            $field->step = $record["step"];
            $field->suffix = $record["suffix"];
            $field->type = $record["type"];
            $field->filter_type = $record["filter_type"];

            //Add dependency relation if there is one
            if($record["dependent_on"])
            {
                $position = SportPosition::where("key", $record["dependent_on"])->first();
                if($position)
                {
                    $field->dependent_on_id = $position->id;
                    $field->dependent_equivalency = ($record['dependent_equivalency'] == 'equals');
                    $field->dependent_on_key = $record["dependent_on"];
                }
            }

            $field->save();
        }
    }
}
