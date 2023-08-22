<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum ToDoStates: string
{
    use EnumTrait;

    case COMPLETED_STATE = 'Completed';
    case OVERDUE_STATE = 'Overdue';
    case NOT_STARTED_STATE = 'Not Started';
    case ON_GOING_STATE = 'On Going';

    public static function states()
    {
        return [
            self::COMPLETED_STATE->value,
            self::OVERDUE_STATE->value,
            self::NOT_STARTED_STATE->value,
            self::ON_GOING_STATE->value,
        ];
    }
}
