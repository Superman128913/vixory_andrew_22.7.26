<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class BaseballOutfieldPosition extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const Right =   0;
    const Center =   1;
    const Left = 2;
}
