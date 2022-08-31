<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class TennisStarRecruit extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const OneStar =   0;
    const TwoStar =   1;
    const ThreeStar = 2;
    const FourStar = 3;
    const FiveStar = 4;
}
