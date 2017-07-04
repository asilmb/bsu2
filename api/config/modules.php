<?php

use yii\helpers\ArrayHelper;

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

if(API_VERSION) {
	$versionConfig = include(ROOT_DIR . DS . 'api' . DS . API_VERSION_STRING . DS . 'config' . DS . 'modules.php');
	return ArrayHelper::merge($config, $versionConfig);
} else {
	return $config;
}
