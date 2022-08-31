<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class SoccerStarter extends Enum implements LocalizedEnum
{
    use EnumHelpers;

    const Starter =   0;
    const NotStarter =   1;
}
