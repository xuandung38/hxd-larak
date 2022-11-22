<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DEFAULT()
 * @method static static HIGH()
 * @method static static LOW()
 */
final class Queues extends Enum
{
    public const DEFAULT = 'default';

    public const HIGH = 'high';

    public const LOW = 'low';
}
