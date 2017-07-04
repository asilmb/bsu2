<?php

return [
	'modules' => [
		'error' => [
			'class' => 'yii2module\error\Module',
		],
		'user' => [
			'class' => 'common\modules\user\Module',
		],
		'admin' => [
			'class' => 'frontend\modules\welcome\Module',
		],
		'balhash' => [
			'class' => 'frontend\modules\balhash\Module',
		],
		'rest-client' => [
            'class' => 'yii2module\rest_client\Module',
            'baseUrl' => env('url.api') . 'v4',
			'storage' => 'yii2module\rest_client\storages\DbStorage',
			'allowedIPs' => ['*'],
			'as access' => [
				'class' => 'yii\filters\AccessControl',
				'rules' => [
					[
						'allow' => true,
						'roles' => ['rest-client.*'],
					],
				],
			],
        ],
		'rest-client-test' => [
            'class' => 'yii2module\rest_client\Module',
            'baseUrl' => env('url.api') . 'index-test.php/v4',
			'storage' => 'yii2module\rest_client\storages\DbStorage',
			'allowedIPs' => ['*'],
			'as access' => [
				'class' => 'yii\filters\AccessControl',
				'rules' => [
					[
						'allow' => true,
						'roles' => ['rest-client.*'],
					],
				],
			],
        ],
	],
];
