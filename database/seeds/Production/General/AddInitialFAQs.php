<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use App\Models\FrequentlyAskedQuestion;

class AddInitialFAQs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Delete all of the existing plans.
        $faqs = FrequentlyAskedQuestion::all();
        foreach($faqs as $faq)
        {
            $faq->delete();
        }

        //Import all of the plans from the csv.
        $csv = Reader::createFromPath(storage_path('docs/faqs.csv'));
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) 
        {
            $faq = new FrequentlyAskedQuestion();
            $faq->question = $record['question'];
            $faq->answer = $record['answer'];
            $faq->save();
        }
    }
}
