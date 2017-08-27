<?php

return [
	'bootstrap' => [],
	'components' => [
		'user' => [
			//'identityClass' => 'yii2lab\user\models\identity\Disc',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
			'loginUrl'=>['user/auth/login'],
		],
		'request' => [
			'csrfParam' => '_csrf-backend',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],
			'cookieValidationKey' => env('cookieValidationKey.frontend'),
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-backend',
		],
		'errorHandler' => [
			'errorAction' => 'error/error/error',
		],
		
		'urlManager' => [
			'rules' => [
				''=> 'dashboard',
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['content' => 'content/page']],
				// ----------------- Active module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['active' => 'active/type']],
				
				'active/<action>' => 'active/type/<action>',

			],
		],
	],
];
