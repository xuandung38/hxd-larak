<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
	/** @var RoleService */
	protected $_roleService;

	/**
	 * RoleController constructor.
	 *
	 * @param RoleService $roleService
	 */
	public function __construct(RoleService $roleService)
	{
		$this->_roleService = $roleService;
	}

	/**
	 * @return Factory|View
	 */
	public function index()
	{
		return view('admin.screens.roles');
	}

	/**
	 * @param StoreRoleRequest $request
	 *
	 * @return JsonResponse
	 */
	public function store(StoreRoleRequest $request)
	{
		return response()->json($this->_roleService->createRole($request->parameters()));
	}

	/**
	 * @param Role             $role
	 * @param StoreRoleRequest $request
	 *
	 * @return JsonResponse
	 */
	public function update(Role $role, StoreRoleRequest $request)
	{
		return response()->json($this->_roleService->updateRole($role, $request->parameters()));
	}


	/**
	 * @param Role $role
	 *
	 * @return JsonResponse
	 */
	public function delete(Role $role)
	{
		return response()->json($this->_roleService->deleteRole($role));
	}
}
