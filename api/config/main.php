<?php

return [
	'bootstrap' => [],
	'timeZone' => 'UTC',
	'components' => [
		'user' => [
			'enableSession' => false, // ! important
			'loginUrl' => null,
			//'identityClass' => 'yii2lab\user\models\identity\Uni',
		],
		'lng' => [
			'store' => [
				'class' => 'yii2module\lang\drivers\store\Headers',
			],
		],
		'request' => [
			'class' => '\yii\web\Request',
			'enableCookieValidation' => false,
			'enableCsrfValidation' => false,
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
		'formatter' => [
			'dateFormat' => 'Y-m-d\TH:i:s\Z',
			'timeFormat' => 'Y-m-d\TH:i:s\Z',
			'datetimeFormat' => 'Y-m-d\TH:i:s\Z',
		],
	],
];
