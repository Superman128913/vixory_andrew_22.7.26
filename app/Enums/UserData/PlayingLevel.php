<?php

namespace App\Enums\UserData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class PlayingLevel extends Enum implements LocalizedEnum
{
    use EnumHelpers;

    const D1 =   0;
    const D2 =   1;
    const D3 = 2;
    const JUCO = 3;
    const Highschool = 4;
    const Professional = 5;
}
