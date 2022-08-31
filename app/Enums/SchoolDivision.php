<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use App\Traits\EnumHelpers;

final class SchoolDivision extends Enum
{
    use EnumHelpers;
    
    const div1 =   0;
    const div2 =   1;
}
