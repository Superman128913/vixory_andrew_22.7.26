<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use App\Traits\EnumHelpers;

final class FieldType extends Enum
{
    use EnumHelpers;
    
    const text =   0;
    const textarea =   1;
    const number = 2;
    const truthy = 3;
    const enum_radio = 4;
    const enum_dropdown = 5;
    const link = 6;
    const enum_checkbox = 7;
    const date = 8;
    const phone = 9;
    const city_search = 10;
    const range_filter = 11;
    const enum_repeater = 12;
}
