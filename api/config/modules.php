<?php

use common\helpers\ApiVersionCofig;

$config = [
	'modules' => [
		'doc' => [
			'class' => 'yii2module\restapidoc\Module',
		],
	],
	'components' => [
		'urlManager' => [
			'rules' => [
				'/' => 'doc',
				API_VERSION_STRING => 'doc/default/view',
			],
		],
	],
];

return ApiVersionCofig::load('modules', $config);
