<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

use App\Models\College;
use \App\Enums\SchoolDivision;
use \App\Enums\SchoolType;
use \App\Enums\StateCode;

class ImportCollegesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate the college table.
        College::truncate();

        //Import all of the colleges from the csv.
        $csv = Reader::createFromPath(storage_path('docs/schools.csv'));
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) 
        {
            $college = new College();
            $college->name = $record['school_name'];
            $college->city = $record['school_city'];

            $reflection = new ReflectionClass('\App\Enums\StateCode');
            $college->state_code = $reflection->getConstant($record['school_state']);

            $reflection = new ReflectionClass('\App\Enums\SchoolType');
            $college_type = $reflection->getConstant($record['school_type']);
            $college->type = $college_type;

            $reflection = new ReflectionClass('\App\Enums\SchoolDivision');
            $college_division = $reflection->getConstant($record['school_div']);
            $college->division = $college_division;

            $college->domain = $record['school_domain'];
            $college->url = $record['school_url'];
            $college->save();
        }
    }
}
