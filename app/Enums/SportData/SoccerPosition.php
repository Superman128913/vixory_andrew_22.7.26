<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class SoccerPosition extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const Goalkeeper = 0;
    const WingBack = 1;
    const FullBack = 2;
    const Sweeper = 3;
    const CentreBack = 4;
    const DefensiveMidfielder = 5;
    const Winger = 6;
    const CentralMidfielder = 7;
    const Striker = 8;
    const AttackingMidfielder = 9;
    const Forward = 10;
}
