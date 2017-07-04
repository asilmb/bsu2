<?php

$access = [
	'class' => 'yii\filters\AccessControl',
	'rules' => [
		[
			'allow' => true,
			'roles' => ['backend.*'],
		],
	],
];

return [
	'modules' => [
		/*
		'backuprestore' => [
			'class' => 'oe\modules\backuprestore\Module',
			'controllerMap' => [
				'default' => [
					'class' => 'oe\modules\backuprestore\controllers\DefaultController',
					'back_temp_file' => 'db_',
				],
			],
			'as access' => $access,
			//'layout' => '@admin-views/layouts/main', or what ever layout you use ... ...
		],
		'settings' => [
			'class' => 'yii2mod\settings\Module',
			// Also you can override some controller properties in following way:
			'controllerMap' => [
				'default' => [
					'class' => 'yii2mod\settings\controllers\DefaultController',
					'searchClass' => [
						'class' => 'yii2mod\settings\models\search\SettingSearch',
						'pageSize' => 25
					],
					//'modelClass' => 'Your own model class',
					//'indexView' => 'custom path to index view file',
					//'createView' => 'custom path to create view file',
					//'updateView' => 'custom path to update view file',
				]
			],
			'as access' => $access,
		],*/
	],
];
