<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategory\StoreBlogCategoryRequest;
use App\Models\BlogCategory;
use App\Services\BlogCategoryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
	/** @var BlogCategoryService */
	protected $_categoryService;

	/**
	 * ProdCategoryController constructor.
	 *
	 * @param BlogCategoryService $categoryService
	 */
	public function __construct(BlogCategoryService $categoryService)
	{
		$this->_categoryService = $categoryService;
	}

	/**
	 * @param Request $request
	 *
	 * @return Application|Factory|View|void
	 */
	public function index(Request $request)
	{
		if (Gate::denies(Permissions::VIEW_BLOG_CATEGORY)) {
			return abort(403, 'Không có quyền');
		}

		$search = $request->input('search', '');
		return view('admin.screens.blog_categories', [
			'categories' => $this->_categoryService->searchCategory($request->all()),
			'keyword' => $search
		]);
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse|void
	 */
	public function search(Request $request)
	{
		if (Gate::denies(Permissions::VIEW_BLOG_CATEGORY)) {
			return abort(403, 'Không có quyền');
		}
		return response()->json($this->_categoryService->searchCategory($request->all()));
	}

	/**
	 * @param StoreBlogCategoryRequest $request
	 *
	 * @return JsonResponse|void
	 */
	public function store(StoreBlogCategoryRequest $request)
	{
		if (Gate::denies(Permissions::EDIT_BLOG_CATEGORY)) {
			return abort(403, 'Không có quyền');
		}
		return response()->json($this->_categoryService->createCategory($request->parameters()));
	}

	/**
	 * @param BlogCategory             $category
	 * @param StoreBlogCategoryRequest $request
	 *
	 * @return JsonResponse|void
	 */
	public function update(BlogCategory $category, StoreBlogCategoryRequest $request)
	{
		if (Gate::denies(Permissions::EDIT_BLOG_CATEGORY)) {
			return abort(403, 'Không có quyền');
		}
		return response()->json($this->_categoryService->updateCategory($category, $request->parameters()));
	}

	/**
	 * @param BlogCategory $category
	 *
	 * @return JsonResponse|void
	 */
	public function delete(BlogCategory $category)
	{
		if (Gate::denies(Permissions::DELETE_BLOG_CATEGORY)) {
			return abort(403, 'Không có quyền');
		}
		return response()->json($this->_categoryService->deleteCategory($category));
	}
}
