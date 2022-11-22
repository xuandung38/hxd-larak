<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class ForgetUserPasswordRequest extends BaseRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'email' => [
                'required',
                'email',
                'max:255',
                'exists:users,email',
            ],
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
            'email' => $this->input('email'),
        ];
    }
}
