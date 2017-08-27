<?php

$isTpsDriver = env('custom.isTpsDriver', true);
$userDriver = $isTpsDriver ? 'tps' : 'disc';
$tpsOrTest = $isTpsDriver ? 'tps' : 'test';
$tpsOrTest = YII_ENV_TEST ? 'test' : $tpsOrTest;

return [
	'components' => [
		'geo' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\geo',
			'repositories' => [
				'region',
				'city',
				'country',
				'currency',
			],
			'services' => [
				'region',
				'city',
				'country',
				'currency',
			],
		],
		'active' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\active',
			'repositories' => [
				'active' => 'ar',
				'field' => 'ar',
				'category' => 'ar',
				'provider' => 'ar',
				'type' => 'ar',
				'option' => 'ar',
				'validation' => 'ar',
				'handler' => 'disc',
			],
			'services' => [
				'active',
				'field',
				'category',
				'provider',
				'type',
				'option',
				'validation',
				'handler',
			],
		],
		'account' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\user',
			'repositories' => [
				'auth' => $userDriver,
				'login' => $userDriver,
				'registration' => $tpsOrTest,
				'temp' => 'ar',
				'restorePassword' => $tpsOrTest,
				'profile' => 'ar',
				'address' => 'ar',
				'car' => 'ar',
				'avatar' => [
					'driver' => 'upload',
					//'quality' => 90,
					'format' => 'png',
					'defaultName' => 'images/icon/avatar.png',
					'size' => 256,
				],
				'security' => $tpsOrTest,
				'test' => 'disc',
				'active' => 'ar',
				'qr' => 'file',
			],
			'services' => [
				'auth',
				'login',
				'registration',
				'temp',
				'restorePassword',
				'profile',
				'address',
				'car',
				'avatar',
				'security',
				'test',
				'active',
				'qr',
			],
		],
		'summary' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\summary',
			'repositories' => [
				'summary',
			],
			'services' => [
				'summary',
			],
		],
		'notify' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\notify',
			'repositories' => [
				'transport',
			],
			'services' => [
				'transport',
			],
		],
		'personal' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\personal',
			'repositories' => [
				'bonus' => 'ar',
			],
			'services' => [
				'bonus',
			],
		],
		'bank' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\bank',
			'repositories' => [
				'banking'=> 'tps',
				'bin' => 'ar',
				'bank' => 'tps',
				'card' => $tpsOrTest,
			],
			'services' => [
				'banking',
				'bin',
				'bank',
				'card',
			],
		],
		'service' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\service',
			'repositories' => [
				'service',
				'field',
				'category',
				'favorite',
			],
			'services' => [
				'service',
				'field',
				'category',
				'favorite',
			],
		],
		'transaction' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\transaction',
			'defaultDriver' => 'tps',
			'repositories' => [
				'payment',
				'history',
				'card',
			],
			'services' => [
				'payment',
				'history',
				'card',
			],
		],
		'convertation' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\convertation',
			'defaultDriver' => 'tps',
			'repositories' => [
				'convertation',
			],
			'services' => [
				'convertation',
			],
		],
	],
];
