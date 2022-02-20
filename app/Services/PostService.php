<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostService
{

	/**
	 * @param $params
	 *
	 * @return mixed
	 */
	public function searchPost($params)
	{
		$query = Post::with('category');
		$query = query_by_cols($query, ['id'], $params);
		if (!empty($params['search'])) {
			$query = search_by_cols($query, $params['search'], [
				'id',
				'name'
			]);
		}
		if (!empty($params['except_id'])) {
			$query->where('id', '<>', $params['except_id']);
		}

		return paginate_with_params($query, $params);
	}

	/**
	 * @param array $postAttributes
	 *
	 * @return mixed
	 */
	public function createPost(array $postAttributes)
	{
		return DB::transaction(function () use ($postAttributes) {
			$post = new Post($postAttributes);
			$post->save();
			$post->slug = Str::slug(($post->name) . '-' . $post->id);
			$post->save();
			return $post->load('category');
		});
	}

	/**
	 * @param Post  $post
	 * @param array $postAttributes
	 *
	 * @return mixed
	 */
	public function updatePost(Post $post, array $postAttributes)
	{
		$post->update($postAttributes);
		return $post->load('category');
	}

	/**
	 * @param Post $post
	 *
	 * @return mixed
	 */
	public function deletePost(Post $post)
	{
		return $post->delete();
	}
}
