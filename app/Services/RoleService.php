<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    /**
     * @param $params
     * @return mixed
     */
    public function searchRole($params)
    {
        $query = Role::with('permissions')->withCount('admins', 'users');

        $query = query_by_cols($query, [
            'id',
            'name',
            'guard',
        ], $params);

        if (! empty($params['search'])) {
            $query = search_by_cols($query, $params['search'], ['id', 'name']);
        }
        if (! empty($params['except_id'])) {
            $query->where('id', '<>', $params['except_id']);
        }

        return paginate_with_params($query, $params);
    }

    /**
     * @param $attributes
     * @return mixed
     */
    public function createRole(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $role = new Role($attributes);
            $role->save();
            $role->permissions()->sync($attributes['permission_ids']);

            return $role->load('permissions');
        });
    }

    /**
     * @param  Role  $role
     * @param  array  $attributes
     * @return mixed
     */
    public function updateRole(Role $role, array $attributes)
    {
        return DB::transaction(function () use ($attributes, $role) {
            $role->update($attributes);
            $role->permissions()->sync($attributes['permission_ids']);

            return $role->load('permissions');
        });
    }

    /**
     * @param  Role  $role
     * @return mixed
     */
    public function deleteRole(Role $role)
    {
        return DB::transaction(function () use ($role) {
            $role->permissions()->sync([]);

            return $role->delete();
        });
    }
}
