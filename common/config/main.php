<?php

use yii2lab\app\helpers\Db;

return [
	'name' => 'Wooppay',
	'language' => 'ru-RU', // current Language
	'sourceLanguage' => 'xx-XX', // Language development
	'bootstrap' => ['log', 'lng'],
	'timeZone' => 'UTC',
	'components' => [
		'user' => [
			'class' => 'api\v4\modules\user\web\User',
			//'identityClass' => 'yii2lab\user\models\identity\Db',
		],
		'httpClient' => [
			'class' => 'yii\httpclient\Client',
		],
				'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
					'except' => [
						'yii\web\HttpException:*',
						YII_ENV_TEST ? 'yii\i18n\PhpMessageSource::loadMessages' : null,
					],
				],
			],
			'traceLevel' => YII_DEBUG ? 3 : 0,
		],
		'authManager' => [
			'class' => 'yii2lab\rbac\rbac\PhpManager',
			'itemFile' => '@common/data/rbac/items.php',
			'ruleFile' => '@common/data/rbac/rules.php',
			'defaultRoles' => ['rGuest'],
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'forceTranslation' => true,
					'basePath' => '@common/messages',
					'sourceLanguage' => 'xx-XX',
				],
			],
		],
		'lng' => [
			'class' => 'yii2module\lang\components\LngComponent',
			'store' => [
				'class' => 'yii2module\lang\drivers\store\Cookies',
				'key' => 'language',
				'extra' => [
					'expireDays' => 30,
					'cookieDomain' => '',
				],
			],
			'languages' => include(COMMON_DIR . DS . 'data' . DS . 'languages.php'),
		],
		'db' => Db::getConfig([
			'class'=>'yii\db\Connection',
			'charset' => 'utf8',
			'enableSchemaCache' => YII_ENV == 'prod',
			/*
			'enableSchemaCache' => true,
			'schemaCacheDuration' => 3600,
			'schemaCache' => 'cache',
			*/
		], YII_ENV_TEST ? 'test' : 'main'),
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',
                'username' => 'asilbekmubarakov@mail.ru',
                'password' => 'enoaYaic',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],


		/* 'settings' => [
			'class' => 'yii2mod\settings\components\Settings',
		], */
	],
];
