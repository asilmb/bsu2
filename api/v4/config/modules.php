<?php

return [
	'modules' => [
		'service' => [
			'class' => 'api\v4\modules\service\Module',
		],
		'user' => [
			'class' => 'api\v4\modules\user\Module',
		],
		'geo' => [
			'class' => 'api\v4\modules\geo\Module',
		],
		'summary' => [
			'class' => 'api\v4\modules\summary\Module',
		],
		'transaction' => [
			'class' => 'api\v4\modules\transaction\Module',
		],
		'card' => [
			'class' => 'api\v4\modules\card\Module',
		],
	],
	'components' => [
		'urlManager' => [
			'rules' => [
				
				// ----------------- User module -----------------
				
				'GET v4/auth' => 'user/auth/info',
				'POST v4/auth' => 'user/auth/login',
				
				'POST v4/registration/<action:(create-account|activate-account|set-password)>' => 'user/registration/<action>',
				
				[
					'class'	  => 'yii\rest\UrlRule',
					'controller' => ['v4/profile' => 'user/profile'],
					'except' => ['delete', 'create', 'index'],
					'extraPatterns' => [
						'<id:\w+>/email' => 'update-email',
						'<id:\w+>/password' => 'update-password',
					],
				],
				
				// ----------------- Geo module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/city' => 'geo/city']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/country' => 'geo/country']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/currency' => 'geo/currency']],
				
				// ----------------- Service module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/service' => 'service/default']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/service-category' => 'service/category'], 'except' => ['delete', 'create', 'update']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/favorite' => 'service/favorite']],
				
				// ----------------- Summary module -----------------
				
				'v4/summary' => 'summary/resource/tree',
				
				// ----------------- Transaction module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/history' => 'transaction/history']],
				
				// ----------------- Card module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/card' => 'card/card']],
				
			],
		],
	],
];
