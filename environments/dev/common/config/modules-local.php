<?php

$config = [];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	
	if(YII_DEBUG) {
		//$config['bootstrap'][] = 'debug';
		$config['modules']['debug'] = [
			'class' => 'yii\debug\Module',
			'allowedIPs' => env('allowedIPs'),
		];
	}
	
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'allowedIPs' => env('allowedIPs'),
		'as access' => [
			'class' => 'yii\filters\AccessControl',
			'rules' => [
				[
					'allow' => true,
					'roles' => ['backend.*'],
				],
			],
		],
	];
	
}

return $config;