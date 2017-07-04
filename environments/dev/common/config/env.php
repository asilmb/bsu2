<?php

$domen = 'wooppay.yii';

return [
	'YII_DEBUG' => true,
	'YII_ENV' => 'dev',
	'url' => [
		'frontend' => 'http://' . $domen . '/',
		'backend' => 'http://admin.' . $domen . '/',
		'api' => 'http://api.' . $domen . '/',
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
			'defaultSchema' => 'woopdb',
		],
		'test' => [
			'host' => 'localhost',
			'username' => 'postgres',
			'password' => '',
			'dbname' => 'wooppay_test',
		],
	],
	'servers' => [
		'tps' => [
			'webPath' => 'http://tps:8080/',
		],
	],
];
