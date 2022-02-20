<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class Permissions extends Enum
{
	const VIEW_USER = 1;
	const EDIT_USER = 2;
	const DELETE_USER = 3;

	const VIEW_BLOG_CATEGORY = 21;
	const EDIT_BLOG_CATEGORY = 22;
	const DELETE_BLOG_CATEGORY = 23;

	const VIEW_POST = 31;
	const EDIT_POST = 32;
	const DELETE_POST = 33;

	const SETTING = 101;
}
