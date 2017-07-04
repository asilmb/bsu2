<?php

return [
	'MaintenanceMode' => false,
	'pageSize' => 25,
	'user.passwordResetTokenExpire' => 3600,
	'url' => env('url'),
	'dee.migration.path' => [
		//'@yii/rbac/migrations',
		//'@mdm/admin/migrations',
		//'@vendor/yii2mod/yii2-settings/migrations',
		'@vendor/yii2module/yii2-rest-client/src/migrations',
	],
	'fixture' => [
		'dir' => '@common/fixtures',
		'exclude' => [
			'migration',
		],
	],
	'offline' => [
		'exclude' => [
			CONSOLE,
			BACKEND,
		],
	],
	'navbar' => [
		'exclude' => [
			'error',
			'offline',
			'user',
			'debug',
			'gii',
			'welcome',
			'lang',
		],
	],
	
	'servers' => env('servers'),
	'MRP' => 2121,
	'EPAY_PERCENT' => 2,
	'EpayPath' => dirname(__FILE__) . '/../../../epay_test/',
	'CnpPath' => dirname(__FILE__) . '/../../../cnp_test/',
	'WooppayPath' => dirname(__FILE__) . '/../../../wp_test/',
	'AcquiringTest' => true,
	'AcquiringType' => 'wooppay',
	'AcquiringAccess' => 70,//epay,cnp,wooppay
	'CardLinkingAccess' => true,
	'CardLinkingType' => 'wooppay',
	'WithdrawalType' => 'wooppay',
	'SPP_ORDER_NOTIFICATION' => 'support@wooppay.com',
	'SECURITY_EMAIL' => 'security@wooppay.com',
	
];