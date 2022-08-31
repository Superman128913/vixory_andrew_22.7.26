<?php

namespace App\Enums\UserData;

use BenSampo\Enum\Enum;
use App\Traits\EnumHelpers;

final class UserDataSex extends Enum
{
    use EnumHelpers;
    
    const Male =   0;
    const Female =   1;
}
