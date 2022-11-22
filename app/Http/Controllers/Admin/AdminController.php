<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /** @var AdminService */
    protected $_adminService;

    /**
     * AdminController constructor.
     *
     * @param  AdminService  $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->_adminService = $adminService;
    }

    /**
     * @param  Request  $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        return view('admin.screens.admins', [
            'admins' => $this->_adminService->searchAdmin($request->all()),
            'keyword' => $request->input('search', ''),
        ]);
    }

    /**
     * @param  StoreAdminRequest  $request
     * @return JsonResponse
     */
    public function store(StoreAdminRequest $request)
    {
        return response()->json($this->_adminService->createAdmin($request->parameters()));
    }

    /**
     * @param  Admin  $admin
     * @param  UpdateAdminRequest  $request
     * @return JsonResponse
     */
    public function update(Admin $admin, UpdateAdminRequest $request)
    {
        return response()->json($this->_adminService->updateAdmin($admin, $request->parameters()));
    }

    /**
     * @param  Admin  $admin
     * @return JsonResponse
     */
    public function delete(Admin $admin)
    {
        return response()->json($this->_adminService->deleteAdmin($admin));
    }
}
