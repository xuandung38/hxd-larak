<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Token
 *
 * @property int $id
 * @property int $user_id
 * @property string $expired_at
 * @property string $token
 * @property int $verification_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $admin_id
 * @property-read Admin|null $admin
 * @property-read User|null $user
 * @method static Builder|Token newModelQuery()
 * @method static Builder|Token newQuery()
 * @method static Builder|Token query()
 * @method static Builder|Token whereCreatedAt($value)
 * @method static Builder|Token whereExpiredAt($value)
 * @method static Builder|Token whereId($value)
 * @method static Builder|Token whereToken($value)
 * @method static Builder|Token whereUpdatedAt($value)
 * @method static Builder|Token whereUserId($value)
 * @method static Builder|Token whereAdminId($value)
 * @method static Builder|Token whereVerificationType($value)
 */
class Token extends Model
{
    /** @var string $table */
    protected $table = 'tokens';

    /** @var array $hidden */
    protected $hidden = [];

    /** @var array $fillable */
    protected $fillable = [
        'user_id',
        'admin_id',
        'expired_at',
        'token',
        'verification_type'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }


    /**
     * @return bool
     */
    public function isExpired()
    {
        $now = strtotime(now());
        $expired = strtotime($this->expired_at);
        return $now > $expired;
    }

    /**
     * @param mixed $value
     *
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = NULL): ?Model
    {
        return $this->whereToken($value)->first();
    }

}
