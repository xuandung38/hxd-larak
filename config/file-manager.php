<?php
return [
	'directory' => 'public/files',
	'anonymous_folder' => 'anonymous',
	'user_storage_limit' => 1024000,
	'anonymous_upload' => true,
	'mimes' => [
		'image/jpg',
		'image/jpeg',
		'image/gif',
		'image/png',
		'image/svg',
		'image/webp',
		'video/webm',
		'video/mp4',
		'application/pdf',
		'application/msword',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.ms-powerpoint',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		'application/vnd.rar',
		'application/vnd.ms-excel',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'application/zip',
	],

	'file_type_array' => [
		'pdf' => 'Adobe Acrobat',
		'doc' => 'Microsoft Word',
		'docx' => 'Microsoft Word',
		'xls' => 'Microsoft Excel',
		'xlsx' => 'Microsoft Excel',
		'zip' => 'Archive',
		'gif' => 'GIF Image',
		'jpg' => 'JPEG Image',
		'jpeg' => 'JPEG Image',
		'png' => 'PNG Image',
		'ppt' => 'Microsoft PowerPoint',
		'pptx' => 'Microsoft PowerPoint',
	],
	'guards' => [
		'user',
		'admin'
	]
];