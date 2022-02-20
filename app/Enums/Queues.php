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
	const DEFAULT = 'default';
	const HIGH = 'high';
	const LOW = 'low';
}
