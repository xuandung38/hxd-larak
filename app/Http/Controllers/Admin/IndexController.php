<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class IndexController extends Controller
{

	/**
	 * @return Application|RedirectResponse|Redirector
	 */
	public function index()
	{
		return redirect(route('admin.profile'));
	}

}
