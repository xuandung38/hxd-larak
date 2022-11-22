<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static EMAIL()
 * @method static static RESET_PASSWORD()
 */
final class VerificationTypes extends Enum
{
    public const EMAIL = 1;

    public const RESET_PASSWORD = 2;
}
