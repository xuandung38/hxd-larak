<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Hash;

class ResetPasswordRequest extends BaseRequest
{
	public function rules()
	{
		return array_merge(parent::rules(), [
			'password' => 'required|max:255|min:6',
			'password_confirm' => 'required|same:password',
		]);
	}

	public function parameters()
	{
		return [
			'password' => Hash::make($this->input('password')),
		];
	}

	public function attributes()
	{
		return [
			'password' => __('admin.common.password'),
			'password_confirm' => __('admin.common.retype_password'),
		];
	}

}
