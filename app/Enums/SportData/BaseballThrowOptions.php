<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class BaseballThrowOptions extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const Left =   0;
    const Right =   1;
}
