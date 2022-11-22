<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @var string */
    protected $table = 'settings';

    /** @var array */
    protected $hidden = [];

    /** @var array */
    protected $fillable = [
        'key',
        'value',
        'status',
    ];
}
