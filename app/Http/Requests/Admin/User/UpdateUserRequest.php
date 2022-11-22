<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name' => 'required|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')
                    ->whereNot('id', $this->input('id')),
            ],
            'password' => 'string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->whereNot('id', $this->input('id')),
            ],
            'phone' => [
                'required',
                'regex:/(0[1-9])+([0-9]{8})\b/',
                Rule::unique('users', 'phone')
                    ->whereNot('id', $this->input('id')),
            ],
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
            'username' => $this->input('username'),
            'password' => $this->input('password'),
            'email' => $this->input('email'),
            'phone' => $this->input('phone'),
            'image' => $this->input('image'),
        ];
    }
}
