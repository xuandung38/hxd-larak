<?php

namespace App\Http\Requests\Admin\Role;

use App\Http\Requests\BaseRequest;

class StoreRoleRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => 'required|max:255',
            'guard' => 'required|in:admin,user',
            'level' => 'required|integer|min:1',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'required|exists:permissions,id',
        ]);
    }
}
