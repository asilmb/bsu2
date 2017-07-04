<?php

return [
	'bootstrap' => [],
	'timeZone' => 'UTC',
	'components' => [
		'user' => [
			'enableSession' => false, // ! important
			'loginUrl' => null,
			'identityClass' => 'yii2lab\user\models\identity\Tps',
		],
		'bank' => 'api\v4\modules\bank\services\BankService',
		'service' => [
			'class' => 'api\v4\modules\service\services\ServiceService',
			'repositoryDriver' => 'ar',
		],
		'card' => [
			'class' => 'api\v4\modules\card\services\card\Service',
			'repositoryClass' => 'RepositoryTps',
		],
		'lng' => [
			'store' => [
				'class' => 'yii2module\lang\drivers\store\Headers',
			],
		],
		'request' => [
			'class' => '\yii\web\Request',
			'enableCookieValidation' => false,
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
				'multipart/form-data' => 'yii\web\MultipartFormDataParser',
			]
		],
		'response' => [
			'format' =>'json',
			'charset' => 'UTF-8',
			'formatters' => [
				'json' => [
					'class' => 'yii\web\JsonResponseFormatter',
					'prettyPrint' => YII_DEBUG,
					'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
				],
			],
		],
		'urlManager' => [
			'enableStrictParsing' => true,
		],
	],
];
