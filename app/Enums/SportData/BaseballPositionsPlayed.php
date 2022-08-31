<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class BaseballPositionsPlayed extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const First =   0;
    const Second =   1;
    const ShortStop = 2;
    const Third = 3;
    const Outfield = 4;
    const Pitcher = 5;
    const Catcher = 6;
}
