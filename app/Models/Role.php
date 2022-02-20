<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Role
 *
 * @method static create(array $attributes)
 * @property int $id
 * @property string $name
 * @property string $guard
 * @property int $level
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Admin[] $admins
 * @property-read int|null $admins_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuard($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereLevel($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 */
class Role extends Model
{
    /** @var string $table */
    protected $table = 'roles';

    /** @var array $hidden */
    protected $hidden = [];

    /** @var array $fillable */
    protected $fillable = [
        'name',
        'guard',
    ];

    /**
     * @return BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_role');
    }

    /**
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

}
