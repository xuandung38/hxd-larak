<?php

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins', 'email'),
            ],
            'phone' => [
                'required',
                'regex:/(0[1-9])+([0-9]{8})\b/',
                Rule::unique('admins', 'phone'),
            ],
            'role_ids' => 'required|array',
            'role_ids.*' => 'required|in:'.implode(',', binding_ids(admin_available_roles())),
            'image' => 'max:255',

        ]);
    }

    /**
     * Prepare parameters from Form Request.
     *
     * @return array
     */
    public function parameters()
    {
        return [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'image' => $this->input('image'),
            'role_ids' => $this->input('role_ids'),
        ];
    }
}
