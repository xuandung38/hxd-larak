<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $logo
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $hotline
 * @property string $email
 * @property string $color
 * @property string $title
 * @property string $keyword
 * @property string $description
 * @property string $thumbnail
 * @property mixed|null $slider
 * @property string|null $instagram
 * @property string|null $facebook
 * @property string|null $youtube
 * @property string|null $twitter
 * @property string|null $spotify
 * @property string|null $soundcloud
 * @property string|null $gg_analytic_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereAddress($value)
 * @method static Builder|Setting whereColor($value)
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereDescription($value)
 * @method static Builder|Setting whereEmail($value)
 * @method static Builder|Setting whereFacebook($value)
 * @method static Builder|Setting whereGgAnalyticId($value)
 * @method static Builder|Setting whereHotline($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereInstagram($value)
 * @method static Builder|Setting whereKeyword($value)
 * @method static Builder|Setting whereLogo($value)
 * @method static Builder|Setting whereName($value)
 * @method static Builder|Setting wherePhone($value)
 * @method static Builder|Setting whereSlider($value)
 * @method static Builder|Setting whereSoundcloud($value)
 * @method static Builder|Setting whereSpotify($value)
 * @method static Builder|Setting whereThumbnail($value)
 * @method static Builder|Setting whereTitle($value)
 * @method static Builder|Setting whereTwitter($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @method static Builder|Setting whereYoutube($value)
 * @method static first()
 * @mixin Eloquent
 * @property float $tax_rate
 * @method static Builder|Setting whereTaxRate($value)
 */
class Setting extends Model
{
    /** @var string $table */
    protected $table = 'setting';

    /** @var array $hidden */
    protected $hidden = [];

    /** @var array $fillable */
    protected $fillable = [
        'logo',
        'name',
        'address',
        'phone',
        'hotline',
        'color',
        'title',
        'keyword',
        'description',
        'thumbnail'
    ];

}
