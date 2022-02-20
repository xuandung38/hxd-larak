<?php

namespace App\Http\Requests\Admin\Post;

use App\Http\Requests\BaseRequest;

class StorePostRequest extends BaseRequest
{
	public function rules()
	{
		return array_merge(parent::rules(), [
			'blog_category_id' => 'required|integer|exists:blog_categories,id',
			'name' => 'required|max:255',
			'description' => 'required',
			'content' => 'required',
			'image' => 'required',
		]);
	}
}
