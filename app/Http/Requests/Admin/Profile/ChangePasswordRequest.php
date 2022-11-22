<?php

namespace App\Http\Requests\Admin\Profile;

use App\Http\Requests\BaseRequest;
use App\Rules\ValidatePassword;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'current' => [
                'required',
                new ValidatePassword(admin()),
            ],
            'new' => 'required|different:current|max:255|min:6',
            'confirm' => 'required|same:new',
        ]);
    }

    public function parameters()
    {
        return [
            'password' => Hash::make($this->input('new')),
        ];
    }

    public function attributes()
    {
        return [
            'current' => __('validation.attributes.current_password'),
            'new' => __('validation.attributes.new_password'),
            'confirm' => __('validation.attributes.retype_password'),
        ];
    }
}
