<?php

return [
	'modules' => [
		'notify' => [
			'class' => 'api\v4\modules\notify\Module',
		],
		'service' => [
			'class' => 'api\v4\modules\service\Module',
		],
		'active' => [
			'class' => 'api\v4\modules\active\Module',
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
		'bank' => [
			'class' => 'api\v4\modules\bank\Module',
		],
		'transfer' => [
			'class' => 'api\v4\modules\transfer\Module',
		],
		'convertation' => [
			'class' => 'api\v4\modules\convertation\Module',
		],
		'personal' => [
			'class' => 'api\v4\modules\personal\Module',
		],
	],
	'components' => [
		'urlManager' => [
			'rules' => [
				
				// ----------------- User module -----------------
				
				'GET v4/auth' => 'user/auth/info',
				'POST v4/auth' => 'user/auth/login',
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/user' => 'user/user']],
				
				'v4/registration/<action:(create-account|activate-account|set-password)>' => 'user/registration/<action>',

				'v4/auth/restore-password/<action:(request|check-code|confirm)>' => 'user/restore-password/<action>',

				'v4/security/<action:(password|email)>' => 'user/security/<action>',
				
				'GET v4/profile' => 'user/profile/view',
				'PUT v4/profile' => 'user/profile/update',
				
				'GET v4/profile-address' => 'user/address/view',
				'PUT v4/profile-address' => 'user/address/update',
				
				'GET v4/profile-car' => 'user/car/view',
				'PUT v4/profile-car' => 'user/car/update',
				
				'GET v4/profile-avatar' => 'user/avatar/view',
				'POST v4/profile-avatar' => 'user/avatar/update',
				'DELETE v4/profile-avatar' => 'user/avatar/delete',
				
				[
					'class'	  => 'yii\rest\UrlRule',
					'controller' => ['v4/user-active' => 'user/active'],
				],
				
				// ----------------- Notify module -----------------
				
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => ['v4/notify' => 'notify/transport'],
					'extraPatterns' => [
						'DELETE' => 'delete-all',
					],
				],
				
				// ----------------- Personal module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/personal/bonus' => 'personal/bonus']],
				
				// ----------------- Geo module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/city' => 'geo/city']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/country' => 'geo/country']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/currency' => 'geo/currency']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/region' => 'geo/region']],
				
				// ----------------- Service module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/service' => 'service/service']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/service-category' => 'service/category'], 'except' => ['delete', 'create', 'update']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/favorite' => 'service/favorite']],
				
				
				// ----------------- Active module -----------------
				
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/active-type' => 'active/type']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/active-field' => 'active/field']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/active-validation' => 'active/validation']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/active-option' => 'active/option']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/active-handler' => 'active/handler']],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v4/active-provider' => 'active/provider']],
				
				// ----------------- Summary module -----------------
				
				'v4/summary' => 'summary/resource/tree',
				
				// ----------------- Transaction module -----------------
				
				'v4/transaction/card' => 'transaction/card/card-wrapper',
			
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => [
						'v4/history' => 'transaction/history',
						'v4/card' => 'transaction/card',
					],
					
					'extraPatterns' => [
						'get-operation-types' => 'get-operation-types',
						'get-states' => 'get-states',
						'get-categories-list' => 'get-categories-list',
					],
					
				],
				// ----------------- Convertation module -----------------
//'v4/convertation' => 'convertation/convertation/index',
				/*
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => [
						'v4/convertation' => 'convertation',
					],
*/
//					'extraPatterns' => [
						'POST v4/convertation/account-to-account' => 'convertation/convertation/account-to-account',
						'POST v4/convertation/card-to-account' => 'convertation/convertation/card-to-account',
						'POST v4/convertation/account-to-card' => 'convertation/convertation/account-to-card',
					//],
				//],

				'v4/payment/<action:(check|pay|pay-from-card|commission|debt|confirm)>' => 'transaction/payment/<action>',
				
				// ----------------- Transfer module -----------------
				
				'v4/transfer/<action>' => 'transfer/default/<action>',
				
				// ----------------- Card module -----------------
				
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => ['v4/card' => 'bank/card'],
					'except' => ['create', 'update'],
					'extraPatterns' => [
						'approve' => 'approve',
					],
				],
				'v4/card/attach' => 'bank/frame/attach',
				
			],
		],
	],
];
