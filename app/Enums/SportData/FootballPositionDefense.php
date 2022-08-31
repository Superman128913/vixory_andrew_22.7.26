<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class FootballPositionDefense extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const DefensiveLineman = 0;
    const Linebacker = 1;
    const Safety = 2;
    const Cornerback = 3;
}
