<?php

$domain = 'wooppay.yii';

return [
	'YII_DEBUG' => true,
	'YII_ENV' => 'dev',
	'url' => [
		'frontend' => 'http://' . $domain . '/',
		'backend' => 'http://admin.' . $domain . '/',
		'api' => 'http://api.' . $domain . '/',
		'static' => 'http://' . $domain . '/',
	],
	'cookieValidationKey' => [
		'frontend' => '_FRONTEND_COOKIE_VALIDATION_KEY_PLACEHOLDER_',
		'backend' => '_BACKEND_COOKIE_VALIDATION_KEY_PLACEHOLDER_',
	],
	'connection' => [
		'main' => [
			'driver' => 'pgsql',
			'host' => 'dbweb',
			'username' => 'logging',
			'password' => 'moneylogger',
			'dbname' => 'wooppay',
			'defaultSchema' => 'salempay',
		],
		'test' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'dbname' => 'wooppay_test',
		],
	],
	'servers' => [
		'tps' => [
			'webPath' => 'http://tps:8080/',
		],
	],
	'config' => [
		'map' => [
			[
				'name' => 'services',
				'merge' => true,
				'withLocal' => true,
				'onlyApps' => ['common'],
			],
		],
	],
	'custom' => [
		'isTpsDriver' => true,
	],
];
