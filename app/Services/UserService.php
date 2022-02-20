<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
	/**
	 * @param $params
	 *
	 * @return mixed
	 */
	public function searchUser($params)
	{
		$query = User::query();
		$query = query_by_cols($query, [
			'id',
			'name',
			'username',
			'email',
			'phone',
		], $params);

		if (!empty($params['search'])) {
			$query = search_by_cols($query, $params['search'], [
				'id',
				'name',
				'username',
				'email',
				'phone']);
		}

		if (!empty($params['except_id'])) {
			$query->where('id', '<>', $params['except_id']);
		}

		return paginate_with_params($query, $params);
	}

	/**
	 * @param $params
	 *
	 * @return mixed
	 */
	public function composer($params)
	{
		$query = User::query();
		$query = query_by_cols($query, [
			'id',
			'name',
			'username',
			'email',
			'phone',
		], $params);

		if (!empty($params['search'])) {
			$query = search_by_cols($query, $params['search'], [
				'id',
				'name',
				'username',
				'email',
				'phone']);
		}

		if (!empty($params['except_id'])) {
			$query->where('id', '<>', $params['except_id']);
		}

		return $query->get();
	}

	/**
	 * @param $attributes
	 *
	 * @return mixed
	 */
	public function createUser(array $attributes)
	{
		if (empty($attributes['password'])) {
			$attributes['password'] = Hash::make(Str::random(16));
		}

		if (empty($attributes['username'])) {
			$attributes['username'] = uniqid();
		}

		return DB::transaction(function () use ($attributes) {
			$user = new User($attributes);
			$user->save();
            if (!empty($attributes['password'])){
                $user->password = $attributes['password'];
                $user->save();
            }
			return $user;
		});
	}

	/**
	 * @param User  $user
	 * @param array $attributes
	 *
	 * @return mixed
	 */
	public function updateUser(User $user, array $attributes)
	{

		return DB::transaction(function () use ($attributes, $user) {
			$user->update($attributes);
			if (!empty($attributes['password'])){
				$user->password = $attributes['password'];
				$user->save();
			}
			return $user;
		});
	}

	/**
	 * @param User $user
	 *
	 * @return mixed
	 */
	public function deleteUser(User $user)
	{
		return DB::transaction(function () use ($user) {
			return $user->delete();
		});
	}

}
