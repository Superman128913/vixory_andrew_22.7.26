<?php

namespace App\Enums\SportData;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Traits\EnumHelpers;

final class BaseballStartRelieve extends Enum implements LocalizedEnum
{
    use EnumHelpers;
    
    const Start =   0;
    const Relieve =   1;
    const Both = 2;
}
