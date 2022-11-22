<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait CodeBindingTrait
{
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        // Retrieve by id or key.
        return is_numeric($value)
            ? static::where('id', $value)->first()
            : static::where('code', $value)->first();
    }
}
