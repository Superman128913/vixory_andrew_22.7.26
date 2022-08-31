<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class BasketballPosition extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const PointGuard = 0;
    const ShootingGuard = 1;
    const PowerForward = 2;
    const SmallForward = 3;
    const Center = 4;
}
