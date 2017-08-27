<?php

return [
	'params' => ['CardLinkingType'=>'wooppay'],
	'mainMenu' => [
		[
			'label' => 'Rest',
			'url' => 'rest-client',
			'access' => ['rest-client.*'],
		],
		[
			'label' => 'transaction',
			'access' => ['@'],
			'module' => 'transaction',
			'items' => [
				[
					'label' => 'payment',
					'url' => 'transaction\payment',
				],
				[
					'label' => 'history',
					'url' => 'history',
				],
				[
					'label' => 'convertation',
					'url' => 'convertation',
				],
			],
		],
		[
			'label' => 'qr-code',
			'url' => '#',
			'module' => 'qrcode',
			'access' => ['@'],
		],
	],
	'rightMenu' => [
		[
			'label' => 'User',
			'module' => 'user',
			'class' => 'common\modules\user\helpers\Navigation',
		],
	],
];