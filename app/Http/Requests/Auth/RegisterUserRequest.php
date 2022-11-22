<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'phone' => [
                'required',
                'regex:/(0[1-9])+([0-9]{8})\b/',
                Rule::unique('users', 'phone'),
            ],
            'password' => 'required|max:50|min:6',
            'password_confirm' => 'required|same:password',
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
            'phone' => $this->input('phone', null),
            'password' => Hash::make($this->input('password')),
            'image' => '/images/avatar.jpg',
        ];
    }

    public function attributes()
    {
        return [
            'password_confirm' => __('admin.common.retype_password'),
        ];
    }
}
