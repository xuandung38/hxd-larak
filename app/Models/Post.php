<?php

namespace App\Models;

use App\Models\Traits\SlugBindingTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $blog_category_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $content
 * @property string $slug
 * @property int $is_custom_page
 * @property int $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read BlogCategory $category
 *
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereBlogCategoryId($value)
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDescription($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereImage($value)
 * @method static Builder|Post whereIsCustomPage($value)
 * @method static Builder|Post whereName($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Post extends Model
{
    use SlugBindingTrait;

    /** @var string */
    protected $table = 'posts';

    /** @var array */
    protected $hidden = [];

    /** @var array */
    protected $fillable = [
        'blog_category_id',
        'name',
        'description',
        'image',
        'content',
        'slug',
        'is_custom_page',
    ];

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
