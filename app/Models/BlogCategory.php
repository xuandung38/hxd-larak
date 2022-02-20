<?php

namespace App\Models;

use App\Models\Traits\SlugBindingTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\Collection;
use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\QueryBuilder;

/**
 * App\Models\BlogCategory
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $slug
 * @property int $is_deleted
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|BlogCategory[] $children
 * @property-read int|null $children_count
 * @property-read Collection|BlogCategory[] $childrenCategories
 * @property-read int|null $children_categories_count
 * @property-read BlogCategory|null $parent
 * @property-read BlogCategory|null $parentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|Post[] $posts
 * @property-read int|null $posts_count
 * @method static Builder|BlogCategory d()
 * @method static QueryBuilder|BlogCategory newModelQuery()
 * @method static QueryBuilder|BlogCategory newQuery()
 * @method static QueryBuilder|BlogCategory query()
 * @method static Builder|BlogCategory whereCreatedAt($value)
 * @method static Builder|BlogCategory whereId($value)
 * @method static Builder|BlogCategory whereImage($value)
 * @method static Builder|BlogCategory whereIsDeleted($value)
 * @method static Builder|BlogCategory whereLft($value)
 * @method static Builder|BlogCategory whereName($value)
 * @method static Builder|BlogCategory whereParentId($value)
 * @method static Builder|BlogCategory whereRgt($value)
 * @method static Builder|BlogCategory whereSlug($value)
 * @method static Builder|BlogCategory whereUpdatedAt($value)
 * @method static Builder|BlogCategory with(...$relations)
 * @mixin Eloquent
 * @method static Collection|static[] all($columns = ['*'])
 * @method static Collection|static[] get($columns = ['*'])
 * @property string $description
 * @method static Builder|BlogCategory whereDescription($value)
 */
class BlogCategory extends Model
{
    use NodeTrait;
    use SlugBindingTrait;

    /** @var string $table */
    protected $table = 'blog_categories';

    /** @var array $hidden */
    protected $hidden = [];

    /** @var array $fillable */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        '_lft',
        '_rgt',
        'parent_id',

    ];

    /**
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function childrenCategories()
    {
        return $this->hasMany(self::class, 'id', 'parent_id');
    }

}
