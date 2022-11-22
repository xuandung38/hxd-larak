<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ChangePasswordRequest;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use App\Services\AdminService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $adminService;

    public function __construct(AdminService $userService)
    {
        $this->adminService = $userService;
    }

    /**
     * @return Application|Factory|View
     */
    public function profile()
    {
        return view('admin.screens.profile');
    }

    /**
     * @param  UpdateProfileRequest  $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->adminService->updateAdmin(admin(), $request->parameters());

        return response()->json(['success' => true]);
    }

    /**
     * @param  ChangePasswordRequest  $request
     * @return JsonResponse
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $this->adminService->updateAdmin(admin(), $request->parameters());

        return response()->json(['success' => true]);
    }
}
