<?php

namespace App\Enums\UserData;

use BenSampo\Enum\Enum;
use App\Traits\EnumHelpers;

final class UserDataSchoolYear extends Enum
{
    use EnumHelpers;
    
    const Freshman =   0;
    const Sophmore =   1;
    const Junior = 2;
    const Senior = 4;
    const Graduate = 5;
}
