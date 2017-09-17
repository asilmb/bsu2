<?php

$isTpsDriver = env('custom.isTpsDriver', true);
$userDriver = $isTpsDriver ? 'tps' : 'disc';
$tpsOrTest = $isTpsDriver ? 'tps' : 'test';
$tpsOrTest = YII_ENV_TEST ? 'test' : $tpsOrTest;

return [
	'components' => [
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
		'content' => [
			'class' => 'common\ddd\Domain',
			'path' => 'api\v4\modules\content',
			'repositories' => [
				'news' => 'ar',
                'image' => 'upload',
			],
			'services' => [
				'news',
                'image'
			],
		],

	],
];
