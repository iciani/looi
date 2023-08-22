<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum ToDoPriorities: string
{
    use EnumTrait;

    case PRIORITY_ONE = '1';
    case PRIORITY_TWO = '2';
    case PRIORITY_THREE = '3';
    case PRIORITY_FOUR = '4';
    case PRIORITY_FIVE = '5';

    public static function priorities()
    {
        return [
            self::PRIORITY_ONE->value,
            self::PRIORITY_TWO->value,
            self::PRIORITY_THREE->value,
            self::PRIORITY_FOUR->value,
            self::PRIORITY_FIVE->value
        ];
    }
}
