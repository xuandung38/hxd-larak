<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

class BlogCategoryComposer
{

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 *
	 * @return void
	 */
	public function compose(View $view)
	{
		$view->with([
			'_activeRoute' => 'admin.blog_categories_index',
			'_breadcrumb' => [
				[
					'label' => 'Danh mục tin tức',
					'route' => route('admin.blog_categories_index')
				],
			],
		]);
	}
}
