<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Setting extends Model
{
    /** @var string $table */
    protected $table = 'settings';

    /** @var array $hidden */
    protected $hidden = [];

    /** @var array $fillable */
    protected $fillable = [
        'key',
        'value',
        'status',
    ];

}
