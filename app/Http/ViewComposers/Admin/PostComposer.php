<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

class PostComposer
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
			'_activeRoute' => 'admin.posts_index',
			'_breadcrumb' => [
				[
					'label' => 'Tin tức',
					'route' => route('admin.posts_index')
				],
			],
		]);
	}
}
