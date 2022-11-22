<?php

namespace App\Models\Traits;

use DateTimeInterface;

trait DateTimeFormatTrait
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('H:i d-m-Y');
    }
}
