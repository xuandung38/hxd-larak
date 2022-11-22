<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    /** @var PostService */
    protected $_postService;

    /**
     * PostController constructor.
     *
     * @param  PostService  $postService
     */
    public function __construct(PostService $postService)
    {
        $this->_postService = $postService;
    }

    /**
     * @param  Request  $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if (Gate::denies(Permissions::VIEW_POST)) {
            return abort(403, 'Không có quyền');
        }

        return view('admin.screens.posts', [
            'posts' => $this->_postService->searchPost($request->all()),
            'keyword' => $request->input('search', ''),
        ]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        if (Gate::denies(Permissions::VIEW_POST)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_postService->searchPost($request->all()));
    }

    /**
     * @param  StorePostRequest  $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        if (Gate::denies(Permissions::EDIT_POST)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_postService->createPost($request->parameters()));
    }

    /**
     * @param  Post  $post
     * @param  StorePostRequest  $request
     * @return JsonResponse
     */
    public function update(Post $post, StorePostRequest $request)
    {
        if (Gate::denies(Permissions::EDIT_POST)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_postService->updatePost($post, $request->parameters()));
    }

    /**
     * @param  Post  $post
     * @return JsonResponse
     */
    public function delete(Post $post)
    {
        if (Gate::denies(Permissions::DELETE_POST)) {
            return abort(403, 'Không có quyền');
        }

        return response()->json($this->_postService->deletePost($post));
    }
}
