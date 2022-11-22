<?php

namespace App\Services;

use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategoryService
{
    /**
     * @param $params
     * @return mixed
     */
    public function searchCategory($params)
    {
        $query = BlogCategory::with('parentCategory');

        if (! empty($params['search'])) {
            $query = search_by_cols($query, $params['search'], [
                'id',
                'name',
            ]);
        }

        if (! empty($params['except_id'])) {
            $query->where('id', '<>', $params['except_id']);
        }

        $query->orderBy('_lft');

        return paginate_with_params($query, $params);
    }

    /**
     * @param  array  $categoryAttributes
     * @return mixed
     */
    public function createCategory(array $categoryAttributes)
    {
        return DB::transaction(function () use ($categoryAttributes) {
            $category = new BlogCategory($categoryAttributes);
            $category->save();
            $category->slug = Str::slug(($category->name).'-'.$category->id);
            $category->save();

            return $category->load('parentCategory');
        });
    }

    /**
     * @param  BlogCategory  $category
     * @param  array  $categoryAttributes
     * @return mixed
     */
    public function updateCategory(BlogCategory $category, array $categoryAttributes)
    {
        return DB::transaction(function () use ($category, $categoryAttributes) {
            $category->update($categoryAttributes);
            $category->slug = Str::slug(($category->name).'-'.$category->id);
            $category->save();

            return $category->load('parentCategory');
        });
    }

    /**
     * @param  BlogCategory  $category
     * @return bool|null
     */
    public function deleteCategory(BlogCategory $category)
    {
        return $category->delete();
    }
}
