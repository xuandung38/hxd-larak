<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends BaseRequest
{
	public function rules()
	{
		return array_merge(parent::rules(), [
			'name' => 'required|max:255',
			'username' => [
				'required',
				'string',
				'max:255',
				Rule::unique('users', 'username'),
			],
            'password' => 'string|max:255',
			'email' => [
				'required',
				'email',
				'max:255',
				Rule::unique('users', 'email')
			],
			'phone' => [
				'max:100',
				Rule::unique('users', 'phone')
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
			'email' => $this->input('email'),
			'username' => $this->input('username'),
            'password' => $this->input('password'),
			'phone' => $this->input('phone'),
			'image' => $this->input('image'),
		];
	}

}
