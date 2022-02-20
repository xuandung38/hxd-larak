<?php

namespace App\Http\ViewComposers\Frontend;

use App\Models\Setting;
use Illuminate\Contracts\View\View;

class HomeComposer
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
		$setting = Setting::first();
		$view->with([
			'_user' => user() ?? null,
			'_setting' => $setting,
			'_notifications' => []
//			'_slider' => !empty($setting->slider) ? json_decode($setting->slider) : [],
		]);
	}
}
