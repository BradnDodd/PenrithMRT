<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self NO_ETA()
 * @method static self NOT_AVAILABLE()
 * @method static self NO_RESPONSE()
 * @method static self from()
 */
final class SarcallETAEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'NO_ETA' => 'No ETA',
            'NOT_AVAILABLE' => 'Not Available',
            'NO_RESPONSE' => '',
        ];
    }
}
