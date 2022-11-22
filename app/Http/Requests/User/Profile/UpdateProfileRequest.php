<?php

namespace App\Http\Requests\User\Profile;

use App\Http\Requests\BaseRequest;

class UpdateProfileRequest extends BaseRequest
{
    public const protectFields = [
        'email_verified_at',
        'password',
    ];

    public function rules()
    {
        $user = user();

        return array_merge(parent::rules(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'username' => 'required|string|unique:admins,username,'.$user->id,
            'phone' => [
                'required',
                'regex:/(0[1-9])+([0-9]{8})\b/',
                'unique:admins,phone,'.$user->id,
            ],
            'image' => 'required',
        ]);
    }

    public function parameters()
    {
        return [
            'name' => $this->input('name'),
            'username' => $this->input('username'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'image' => $this->input('image'),
        ];
    }

    public function authorize()
    {
        return true;
    }
}
