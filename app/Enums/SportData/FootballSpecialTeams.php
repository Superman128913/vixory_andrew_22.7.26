<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class FootballSpecialTeams extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const Kicker =   0;
    const Punter =   1;
}
