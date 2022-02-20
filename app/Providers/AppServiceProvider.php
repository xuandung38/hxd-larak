<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Set https
		if ($this->app['config']['app.force_https']) {
			$this->app['request']->server->set('HTTPS', 'on');
		}

		// Listen user events
		// User::observe(UserObserver::class);

		// Set default pagination view
		// Paginator::defaultView('shop.layouts.pagination');
	}
}
