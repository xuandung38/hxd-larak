<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SettingController extends Controller
{
	/**
	 * @return Factory|View
	 */
	public function index()
	{
		if (Gate::denies(Permissions::SETTING)) {
			return abort(403, 'Không có quyền');
		}

		return view('admin.screens.setting', [
			'setting' => Setting::first(),
		]);
	}

	/**
	 * @param Setting              $setting
	 * @param UpdateSettingRequest $request
	 *
	 * @return JsonResponse
	 */
	public function update(Setting $setting, UpdateSettingRequest $request)
	{
		if (Gate::denies(Permissions::SETTING)) {
			return abort(403, 'Không có quyền');
		}

		$setting->update($request->parameters());
		return response()->json($setting);
	}
}
