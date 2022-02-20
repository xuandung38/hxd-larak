<?php

namespace App\Http\Requests\Admin\BlogCategory;

use App\Http\Requests\BaseRequest;

class StoreBlogCategoryRequest extends BaseRequest
{
	public function rules()
	{
		return array_merge(parent::rules(), [
			'name' => 'required|max:255',
		]);
	}

}
