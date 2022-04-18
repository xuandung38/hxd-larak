<?php

namespace App\Providers;

use App\Http\ViewComposers\Admin as AdminCPS;
use App\Http\ViewComposers\Frontend as Frontend;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Frontend
		view()->composer('frontend.screens.profile', Frontend\ProfileComposer::class);
		view()->composer('frontend.layouts.*', Frontend\HomeComposer::class);
		view()->composer('frontend.screens.*', Frontend\HomeComposer::class);


		// Admin
		// view()->composer(['admin.layouts.*'], AdminCPS\IndexComposer::class);
		view()->composer(['admin.screens.*'], AdminCPS\IndexComposer::class);
		view()->composer(['admin.screens.admins'], AdminCPS\AdminComposer::class);
		view()->composer(['admin.screens.files'], AdminCPS\FileComposer::class);
		view()->composer(['admin.screens.users'], AdminCPS\UserComposer::class);
		view()->composer(['admin.screens.profile'], AdminCPS\ProfileComposer::class);
		view()->composer(['admin.screens.blog_categories'], AdminCPS\BlogCategoryComposer::class);
		view()->composer(['admin.screens.posts'], AdminCPS\PostComposer::class);
		view()->composer(['admin.screens.setting'], AdminCPS\SettingComposer::class);
		view()->composer(['admin.screens.roles'], AdminCPS\RoleComposer::class);
	}
}
