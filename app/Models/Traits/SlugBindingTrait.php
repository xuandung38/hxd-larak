<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait SlugBindingTrait
{
	public function resolveRouteBinding($value, $field = NULL): ?Model
	{
		// Retrieve by id or key.
		return is_numeric($value)
			? static::where('id', $value)->first()
			: static::where('slug', $value)->first();
	}
}
