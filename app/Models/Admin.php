<?php

namespace App\Models;

use App\Models\Traits\DateTimeFormatTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $image
 * @property int|null $fb_account_id
 * @property int $role
 * @property Carbon|null
 *           $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null
 *                $notifications_count
 *
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static Builder|Admin query()
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereEmail($value)
 * @method static Builder|Admin whereEmailVerifiedAt($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin whereImage($value)
 * @method static Builder|Admin whereName($value)
 * @method static Builder|Admin whereUserName($value)
 * @method static Builder|Admin wherePassword($value)
 * @method static Builder|Admin wherePhone($value)
 * @method static Builder|Admin whereRememberToken($value)
 * @method static Builder|Admin whereRole($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 *
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|Token[] $verifications
 * @property-read int|null
 *                $verifications_count
 */
class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use DateTimeFormatTrait;

    /** @var string */
    protected $guard = 'admin';

    /** @var string */
    protected $table = 'admins';

    /** @var array */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** @var array */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'image',
        'role',
        'email_verified_at',
        'password',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role');
    }

    /**
     * @return HasMany
     */
    public function verifications()
    {
        return $this->hasMany(Token::class);
    }

    /**
     * @param $permissionKey
     * @return bool
     */
    public function canDo($permissionKey)
    {
        $user = $this->load('roles.permissions');

        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->key === $permissionKey) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param  mixed  $value
     * @param  null  $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return is_numeric($value)
            ? static::whereId($value)->first()
            : static::whereUserName($value)->first();
    }
}
