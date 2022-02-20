<?php

namespace App\Http\Requests\Admin\Profile;

use App\Http\Requests\BaseRequest;

class UpdateProfileRequest extends BaseRequest
{
	public function rules()
	{
		$admin = admin();

		return array_merge(parent::rules(), [
			'name' => 'required|max:255',
			'email' => 'required|email|unique:admins,email,' . $admin->id,
			'username' => 'required|string|unique:admins,username,' . $admin->id,
			'phone' => [
				'required',
				'regex:/(0[1-9])+([0-9]{8})\b/',
				'unique:admins,phone,' . $admin->id,
			],
			'image' => 'required',
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
			'email' => $this->input('email'),
			'phone' => $this->input('phone'),
			'image' => $this->input('image'),
		];
	}
}
