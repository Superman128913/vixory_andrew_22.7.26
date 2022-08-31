<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use App\Traits\EnumHelpers;

final class SchoolType extends Enum
{
    const NCAA = 0;
    const juco = 1;
    const naia = 2;
}
