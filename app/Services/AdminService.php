<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminService
{
    /**
     * @param $params
     * @return LengthAwarePaginator
     */
    public function searchAdmin($params): LengthAwarePaginator
    {
        $query = Admin::with('roles');
        $query = query_by_cols($query, [
            'id',
            'email',
            'phone',
        ], $params);

        if (! empty($params['search'])) {
            $query = search_by_cols($query, $params['search'], [
                'id',
                'email',
                'phone',
            ]);
        }

        if (! empty($params['except_id'])) {
            $query->where('id', '<>', $params['except_id']);
        }

        return paginate_with_params($query, $params);
    }

    /**
     * @param  array  $attributes
     * @return mixed
     */
    public function createAdmin(array $attributes)
    {
        if (empty($attributes['password'])) {
            $attributes['password'] = Hash::make(Str::random());
        }

        return DB::transaction(function () use ($attributes) {
            $admin = new Admin($attributes);
            $admin->save();

            if (! empty($attributes['role_ids'])) {
                $admin->roles()->sync($attributes['role_ids']);
            }

            return $admin->load('roles');
        });
    }

    /**
     * @param  Admin  $admin
     * @param  array  $attributes
     * @return mixed
     */
    public function updateAdmin(Admin $admin, array $attributes)
    {
        return DB::transaction(function () use ($attributes, $admin) {
            $admin->update($attributes);

            if (! empty($attributes['password'])) {
                $admin->password = $attributes['password'];
                $admin->save();
            }

            if (! empty($attributes['role_ids'])) {
                $admin->roles()->sync($attributes['role_ids']);
            }

            return $admin->load('roles');
        });
    }

    /**
     * @param  Admin  $admin
     * @return mixed
     */
    public function deleteAdmin(Admin $admin)
    {
        return DB::transaction(function () use ($admin) {
            $admin->roles()->sync([]);

            return $admin->delete();
        });
    }
}
