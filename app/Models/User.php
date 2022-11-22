<?php

namespace App\Models;

use App\Models\Traits\DateTimeFormatTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use DateTimeFormatTrait;
    use HasFactory;

    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'image',
        'last_login',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'count_unread_messages' => 'integer',
    ];

    /**
     * @return HasMany
     */
    public function verifications()
    {
        return $this->hasMany(Token::class);
    }

    /**
     * @param  mixed  $value
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return is_numeric($value)
            ? static::whereId($value)->first()
            : static::whereUserName($value)->first();
    }
}
