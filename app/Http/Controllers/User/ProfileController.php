<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\ChangePasswordRequest;
use App\Http\Requests\User\Profile\UpdateProfileRequest;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $_userService;

    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;
    }

    /**
     * @param  Request  $request
     * @return Application|Factory|View
     */
    public function profile(Request $request)
    {
        return view('frontend.screens.profile');
    }

    /**
     * @param  UpdateProfileRequest  $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->_userService->updateUser(user(), $request->parameters());

        return response()->json(['success' => true]);
    }

    /**
     * @param  ChangePasswordRequest  $request
     * @return JsonResponse
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $this->_userService->updateUser(user(), $request->parameters());

        return response()->json(['success' => true]);
    }
}
