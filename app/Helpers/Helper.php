<?php

use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


if (!function_exists('current_guard')) {
	function current_guard()
	{
		if (auth('admin')->check()) {
			return "admin";
		}

		if (auth('user')->check()) {
			return "user";
		}

		return 'guest';
	}
}

if (!function_exists('admin')) {
	function admin()
	{
		if (auth('admin')->check()) {
			return auth('admin')->user()->load('roles');
		}

		return null;
	}
}

if (!function_exists('is_system_admin')) {
	function is_system_admin($admin)
	{
		foreach ($admin->roles as $role) {
			if ($role->id === (int)config('app.system_role_id')) {
				return true;
			}
		}
		return false;
	}
}

if (!function_exists('user')) {
	function user(array $relation = [])
	{
		if (auth('user')->check()) {
			return Auth::guard('user')->user()->load($relation);
		}

		return null;
	}
}

if (!function_exists('get_enum_keys')) {
	function get_enum_keys(array $items)
	{
		$data = [];

		foreach ($items as $item) {
			$data[] = $item->getKey();
		}

		return $data;
	}
}

if (!function_exists('get_enum_values')) {
	function get_enum_values(array $items)
	{
		$data = [];

		foreach ($items as $item) {
			$data[] = $item->getValue()['value'];
		}

		return $data;
	}
}

if (!function_exists('get_enum_by_key')) {
	function get_enum_by_key($items, $key)
	{
		foreach ($items as $item) {
			if ($item->getKey() === $key) {
				return $item;
			}
		}

		return null;
	}
}

if (!function_exists('get_enum_by_value')) {
	function get_enum_by_value($items, $targetValue)
	{
		foreach ($items as $item) {
			$value = $item->getValue();

			if (is_array($value)) {
				if ($value['value'] === (int)$targetValue) {
					return $item;
				}
			} else {
				if ($value === (int)$targetValue) {
					return $item;
				}
			}
		}

		return null;
	}
}

if (!function_exists('binding_enum')) {
	function binding_enum($enum, string $langKey, string $keyName = 'key', string $labelName = 'name', string $valueName = 'value')
	{
		$data = [];

		foreach ($enum as $item) {
			$data[] = [
				$keyName => $item->getKey(),
				$labelName => __('enum.' . $langKey . '.' . strtolower($item->getKey())),
				$valueName => $item->getValue(),
			];
		}

		return $data;
	}
}

if (!function_exists('binding_collection')) {
	function binding_collection($collection, string $keyName = 'key', string $labelName = 'name', string $valueName = 'value')
	{
		$data = [];

		foreach ($collection as $item) {
			$data[] = [
				$keyName => $item->id,
				$labelName => $item->name,
				$valueName => $item->id,
			];
		}

		return $data;
	}
}

if (!function_exists('binding_ids')) {
	function binding_ids($items)
	{
		$data = [];

		foreach ($items as $item) {
			$data[] = $item->id;
		}

		return $data;
	}
}

if (!function_exists('admin_available_roles')) {
	function admin_available_roles($admin = null, $roles = null)
	{
		if (empty($admin)) {
			$admin = admin();
		}
		if (empty($roles)) {
			$roles = Role::whereGuard('admin')->get();
		}

		$data = [];
		$highestLevel = null;

		foreach ($admin->roles as $role) {

			if ($highestLevel === null) {
				$highestLevel = $role->level;
				continue;
			}

			if ($role->level < $highestLevel) {
				$highestLevel = $role->level;
			}
		}

		foreach ($roles as $role) {

			if ($role->level >= $highestLevel) {
				$data[] = $role;
			}
		}

		return $data;
	}
}


if (!function_exists('random_unique_key')) {
	function random_unique_key()
	{
		return Str::random(3) . uniqid();
	}
}

if (!function_exists('query_by_cols')) {
	function query_by_cols(Builder $query, array $cols = [], array $params = []): Builder
	{
		foreach ($cols as $col) {
			if (!empty($params[$col])) {
				$query->where($col, $params[$col]);
			}
		}

		return $query;
	}
}

if (!function_exists('search_by_cols')) {
	function search_by_cols(Builder $query, $value, array $cols = []): Builder
	{
		foreach ($cols as $col) {
			$query->orWhere($col, 'like', '%' . $value . '%');
		}

		return $query;
	}
}

if (!function_exists('paginate_with_params')) {
	function paginate_with_params(Builder $query, array $params = []): LengthAwarePaginator
	{
		$perPage = config('app.pagination');

		if (!empty($params['per_page'])) {
			$perPage = (int)$params['per_page'];
		}

		return $query->paginate($perPage);
	}
}
if (!function_exists('binding_meta_seo')) {
	function binding_meta_seo($data, $route)
	{
		$meta = new StdClass();
		$meta->name = $data->name ?? '';
		$meta->tag = $data->tag ?? $meta->name;
		$meta->description = $data->short_description ?? '';
		$meta->image = $data->image ?? '';
		$meta->url = $route;

		return $meta;
	}
}
