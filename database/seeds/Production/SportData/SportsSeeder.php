<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use App\Models\Sport;

class SportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate the college table.
        Sport::truncate();

        //Import all of the colleges from the csv.
        $csv = Reader::createFromPath(storage_path('docs/sports.csv'));
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) 
        {
            $sport = new Sport();
            $sport->name = $record['name'];
            $sport->icon_class = $record['classes'];
            $sport->is_active = !($record['active'] == 'false');
            $sport->save();
        }
    }
}
