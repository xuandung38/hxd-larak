<?php

namespace App\Http\ViewComposers\Admin;

use App\Enums\BannerType;
use Illuminate\Contracts\View\View;

class SettingComposer
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
			'_activeRoute' => 'admin.setting_index',
			'_breadcrumb' => [
				[
					'label' => 'Cài đặt',
					'route' => route('admin.setting_index')
				],
			],
		]);
	}
}
