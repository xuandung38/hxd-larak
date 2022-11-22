<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    /** @var UserService */
    protected $_userService;

    /**
     * UserController constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;
    }

    /**
     * @param  Request  $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if (Gate::denies(Permissions::VIEW_USER)) {
            return abort(403, 'Không có quyền');
        }

        return view('admin.screens.users', [
            'users' => $this->_userService->searchUser($request->all()),
            'keyword' => $request->input('search', ''),
        ]);
    }

    /**
     * @param  StoreUserRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        if (Gate::denies(Permissions::EDIT_USER)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_userService->createUser($request->parameters()));
    }

    /**
     * @param  User  $user
     * @param  UpdateUserRequest  $request
     * @return JsonResponse
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        if (Gate::denies(Permissions::EDIT_USER)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_userService->updateUser($user, $request->parameters()));
    }

    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function delete(User $user)
    {
        if (Gate::denies(Permissions::DELETE_USER)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_userService->deleteUser($user));
    }

    /**
     * @return BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }
}
