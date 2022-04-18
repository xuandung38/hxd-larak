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

        $settings = Setting::all();

        $arrSettings = [];
        foreach ($settings as $setting) {
            $arrSettings[$setting->key] = $setting->value;
        }

        return view('admin.screens.setting', [
            'setting' => $arrSettings,
        ]);
    }

    /**
     * @param Setting              $setting
     * @param UpdateSettingRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateSettingRequest $request)
    {
        if (Gate::denies(Permissions::SETTING)) {
            return abort(403, 'Không có quyền');
        }
        $settings = $request->parameters() ?? [];

        foreach ($settings as $key => $setting) {
            Setting::where('key', $key)->update(['value' => $setting]);
        }
        return response()->json($settings);
    }
}
