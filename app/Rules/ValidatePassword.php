<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ValidatePassword implements Rule
{
	protected $user;

	/**
	 * Create a new rule instance.
	 *
	 */
	public function __construct()
	{
		$this->user = current_guard() === 'admin' ? admin() : user();
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		return Hash::check($value, $this->user->password);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return trans('validation.password_not_match');
	}
}
