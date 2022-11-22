<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Permissions extends Enum
{
    public const VIEW_USER = 1;

    public const EDIT_USER = 2;

    public const DELETE_USER = 3;

    public const VIEW_BLOG_CATEGORY = 21;

    public const EDIT_BLOG_CATEGORY = 22;

    public const DELETE_BLOG_CATEGORY = 23;

    public const VIEW_POST = 31;

    public const EDIT_POST = 32;

    public const DELETE_POST = 33;

    public const SETTING = 101;
}
