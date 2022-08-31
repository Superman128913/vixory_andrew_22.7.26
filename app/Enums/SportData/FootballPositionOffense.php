<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class FootballPositionOffense extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const Quarterback =   0;
    const RunningBack =   1;
    const WideReceiver = 2;
    const TightEnd = 3;
    const OffensiveTackle = 4;
    const OffensiveGuard = 5;
    const Center = 6;
}
