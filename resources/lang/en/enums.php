<?php

use App\Enums\SportData\BaseballBatOptions;
use App\Enums\SportData\BaseballOutfieldPosition;
use App\Enums\SportData\BaseballPositionsPlayed;
use App\Enums\SportData\BaseballStartRelieve;
use App\Enums\SportData\BaseballThrowOptions;
use App\Enums\SportData\BasketballPosition;
use App\Enums\SportData\FootballPositionDefense;
use App\Enums\SportData\FootballPositionOffense;
use App\Enums\SportData\FootballSpecialTeams;
use App\Enums\SportData\TennisStarRecruit;
use App\Enums\SportData\SoccerPosition;
use App\Enums\SportData\SoccerStarter;

use App\Enums\UserData\PlayingLevel;

return [
    PlayingLevel::class => [
        PlayingLevel::D1 => 'Division 1',
        PlayingLevel::D2 => 'Division 2',
        PlayingLevel::D3 => 'Division 3',
        PlayingLevel::JUCO => 'JUCO',
        PlayingLevel::Highschool => 'High School',
        PlayingLevel::Professional => 'Professional',
    ],
    BaseballBatOptions::class => [
        BaseballBatOptions::Left => 'Left',
        BaseballBatOptions::Right => 'Right',
        BaseballBatOptions::Switch => 'Switch',
    ],
    BaseballOutfieldPosition::class => [
        BaseballOutfieldPosition::Right => 'Right',
        BaseballOutfieldPosition::Center => 'Center',
        BaseballOutfieldPosition::Left => 'Left'
    ],
    BaseballPositionsPlayed::class => [
        BaseballPositionsPlayed::First => 'First',
        BaseballPositionsPlayed::Second => 'Second',
        BaseballPositionsPlayed::ShortStop => 'Short Stop',
        BaseballPositionsPlayed::Third => 'Third',
        BaseballPositionsPlayed::Outfield => 'Outfield',
        BaseballPositionsPlayed::Pitcher => 'Pitcher',
        BaseballPositionsPlayed::Catcher => 'Catcher'
    ],
    BaseballStartRelieve::class => [
        BaseballStartRelieve::Start => 'Start',
        BaseballStartRelieve::Relieve => 'Relieve',
        BaseballStartRelieve::Both => 'Both'
    ],
    BaseballThrowOptions::class => [
        BaseballThrowOptions::Left => 'Left',
        BaseballThrowOptions::Right => 'Right'
    ],
    BasketballPosition::class => [
        BasketballPosition::PointGuard => 'Point Guard (PG)',
        BasketballPosition::ShootingGuard => 'Shooting Guard (SG)',
        BasketballPosition::PowerForward => 'Power Forward (PF)',
        BasketballPosition::SmallForward => 'Small Forward (SF)',
        BasketballPosition::Center => 'Center ©',
    ],
    FootballPositionDefense::class => [
        FootballPositionDefense::DefensiveLineman => 'Defensive Lineman (DL)',
        FootballPositionDefense::Linebacker => 'Linebacker (LB)',
        FootballPositionDefense::Safety => 'Safety (S)',
        FootballPositionDefense::Cornerback => 'Cornerback (CB)',
    ],
    FootballPositionOffense::class => [
        FootballPositionOffense::Quarterback => 'Quarterback (QB)',
        FootballPositionOffense::RunningBack => 'Running Back (RB)',
        FootballPositionOffense::WideReceiver => 'Wide Receiver (WR)',
        FootballPositionOffense::TightEnd => 'Tight End (TE)',
        FootballPositionOffense::OffensiveTackle => 'Offensive Tackle (T)',
        FootballPositionOffense::OffensiveGuard => 'Offensive Guard (G)',
        FootballPositionOffense::Center => 'Center ©',
    ],
    FootballSpecialTeams::class => [
        FootballSpecialTeams::Kicker => 'Kicker',
        FootballSpecialTeams::Punter => 'Punter'
    ],
    TennisStarRecruit::class => [
        TennisStarRecruit::OneStar => '1 Star',
        TennisStarRecruit::TwoStar => '2 Star',
        TennisStarRecruit::ThreeStar => '3 Star',
        TennisStarRecruit::FourStar => '4 Star',
        TennisStarRecruit::FiveStar => '5 Star'
    ],
    SoccerPosition::class => [
        SoccerPosition::Goalkeeper => 'Goalkeeper',
        SoccerPosition::WingBack => 'Wing-Back',
        SoccerPosition::FullBack => 'Full-Back',
        SoccerPosition::Sweeper => 'Sweeper',
        SoccerPosition::CentreBack => 'Centre-Back',
        SoccerPosition::DefensiveMidfielder => 'Defensive Midfielder',
        SoccerPosition::Winger => 'Winger',
        SoccerPosition::CentralMidfielder => 'Central Midfielder',
        SoccerPosition::Striker => 'Striker',
        SoccerPosition::AttackingMidfielder => 'Attacking Midfielder',
        SoccerPosition::Forward => 'Forward',
    ],
    SoccerStarter::class => [
        SoccerStarter::Starter => 'Starter',
        SoccerStarter::NotStarter => 'Not Starter',
    ],
];