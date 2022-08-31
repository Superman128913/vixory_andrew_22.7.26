<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers;

class Sport extends Model
{
    protected $with = ['sportpositions'];
    protected $appends = ['enums'];

    //Relations
    public function sportpositions()
    {
        return $this->hasMany('App\Models\SportPosition');
    }

    public function profilethemes()
    {
        return $this->hasMany('App\Models\ProfileTheme');
    }

    public function sportfields()
    {
        return $this->hasMany('App\Models\SportField');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    //Enumeration logic
    public function getEnumsAttribute()
    {
        switch($this->name)
        {
            case "Baseball":
                return $this->getBaseballEnums();
            case "Softball":
                return $this->getSoftballEnums();
            case "Basketball":
                return $this->getBasketballEnums();
            case "Football":
                return $this->getFootballEnums();
            case "Tennis":
                return $this->getTennisEnums();
            case "Soccer":
                return $this->getSoccerEnums();
        }
    }

    private function getBaseballEnums()
    {
        $baseball_bat_options = \App\Enums\SportData\BaseballBatOptions::toObjectArray();
        $baseball_outfield_position = \App\Enums\SportData\BaseballOutfieldPosition::toObjectArray();
        $baseball_positions_played = \App\Enums\SportData\BaseballPositionsPlayed::toObjectArray();
        $baseball_start_relieve = \App\Enums\SportData\BaseballStartRelieve::toObjectArray();
        $baseball_throw_options = \App\Enums\SportData\BaseballBatOptions::toObjectArray();

        return [
            "baseball_bat_options" => $baseball_bat_options,
            "baseball_outfield_position" => $baseball_outfield_position,
            "baseball_positions_played" => $baseball_positions_played,
            "baseball_start_relieve" => $baseball_start_relieve,
            "baseball_throw_options" => $baseball_throw_options
        ];
    }

    private function getSoftballEnums()
    {

        return [];
    }

    private function getBasketballEnums()
    {
        $basketball_position = \App\Enums\SportData\BasketballPosition::toObjectArray();
        return [
            "basketball_position" => $basketball_position
        ];
    }

    private function getFootballEnums()
    {
        $football_position_defense = \App\Enums\SportData\FootballPositionDefense::toObjectArray();
        $football_position_offense = \App\Enums\SportData\FootballPositionOffense::toObjectArray();
        $football_special_teams = \App\Enums\SportData\FootballSpecialTeams::toObjectArray();

        return [
            'football_position_defense' => $football_position_defense,
            'football_position_offense' => $football_position_offense,
            'football_special_teams'    => $football_special_teams
        ];
    }

    private function getTennisEnums()
    {
        $tennis_star_recruit = \App\Enums\SportData\TennisStarRecruit::toObjectArray();
        $tennis_dominate_hand = \App\Enums\SportData\TennisDominateHand::toObjectArray();

        return [
            'tennis_star_recruit' => $tennis_star_recruit,
            'tennis_dominate_hand' => $tennis_dominate_hand
        ];
    }

    private function getSoccerEnums()
    {
        $soccer_position = \App\Enums\SportData\SoccerPosition::toObjectArray();
        $soccer_starter = \App\Enums\SportData\SoccerStarter::toObjectArray();

        return [
            'soccer_position' => $soccer_position,
            'soccer_starter_or_non_starter' => $soccer_starter
        ];
    }
}
