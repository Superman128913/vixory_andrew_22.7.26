<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Storage;

use App\Models\Sport;
use App\Models\ProfileTheme;

class AddCoverImages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Delete all of the existing profile themes.
        $themes = ProfileTheme::all();
        foreach($themes as $theme)
        {
            $theme->delete();
        }

        //Add in the new ones
        Storage::disk('public')->put('soccer-cover.jpg', $this->getImage("images/design/cover/soccer-cover.jpg"));
        $soccer = Sport::where("name", "=", "Soccer")->first();
        $soccer_theme = ProfileTheme::create([
            'sport_id'  => $soccer->id,
            'image'     => "soccer-cover.jpg"
        ]);

        Storage::disk('public')->put('basketball-cover-1.jpg', $this->getImage("images/design/cover/basketball-cover-1.jpg"));
        $basketball = Sport::where("name", "=", "Basketball")->first();
        $basketball_theme = ProfileTheme::create([
            'sport_id'  => $basketball->id,
            'image'     => 'basketball-cover-1.jpg'
        ]);

        Storage::disk('public')->put('basketball-cover-2.jpg', $this->getImage("images/design/cover/basketball-cover-2.jpg"));
        $basketball2 = Sport::where("name", "=", "Basketball")->first();
        $basketball2_theme = ProfileTheme::create([
            'sport_id'  => $basketball2->id,
            'image'     => 'basketball-cover-2.jpg'
        ]);

        Storage::disk('public')->put('baseball-cover.jpg', $this->getImage("images/design/cover/baseball-cover.jpg"));
        $baseball = Sport::where("name", "=", "Baseball")->first();
        $baseball_theme = ProfileTheme::create([
            'sport_id'  => $baseball->id,
            'image'     => 'baseball-cover.jpg'
        ]);

        Storage::disk('public')->put('football-cover.jpg', $this->getImage("images/design/cover/football-cover.jpg"));
        $baseball = Sport::where("name", "=", "Football")->first();
        $baseball_theme = ProfileTheme::create([
            'sport_id'  => $baseball->id,
            'image'     => 'football-cover.jpg'
        ]);

        Storage::disk('public')->put('softball-cover.jpg', $this->getImage("images/design/cover/softball-cover.jpg"));
        $baseball = Sport::where("name", "=", "Softball")->first();
        $baseball_theme = ProfileTheme::create([
            'sport_id'  => $baseball->id,
            'image'     => 'softball-cover.jpg'
        ]);

        Storage::disk('public')->put('tennis-cover.jpg', $this->getImage("images/design/cover/tennis-cover.jpg"));
        $tennis = Sport::where("name", "=", "Tennis")->first();
        $tennis_theme = ProfileTheme::create([
            'sport_id'  => $tennis->id,
            'image'     => 'tennis-cover.jpg'
        ]);
    }

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
