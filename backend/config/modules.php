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
		'error' => [
			'class' => 'yii2module\error\Module',
		],
		'user' => [
			'class' => 'common\modules\user\Module',
			'controllerMap' => [
				'auth' => [
					'class' => 'common\modules\user\controllers\AuthController',
					'layout' => '@backend/views/layouts/singleForm.php',
				],
			],
		],
		'dashboard' => [
			'class' => 'backend\modules\dashboard\Module',
			'as access' => $access,
		],
		'app' => [
			'class' => 'backend\modules\app\Module',
			'as access' => $access,
		],
		'rbac' => [
			'class' => 'mdm\admin\Module',
			'controllerMap' => [
				'assignment' => [
					'class' => 'mdm\admin\controllers\AssignmentController',
					'userClassName' => 'yii2lab\user\models\identity\Db',
				],
			],
			'as access' => $access,
		],
		'gridview' => [
			'class' => 'kartik\grid\Module'
		],
		'logreader' => [
            'class' => 'zhuravljov\yii\logreader\Module',
            'aliases' => [
                'Frontend' => '@frontend/runtime/logs/app.log',
                'Backend' => '@backend/runtime/logs/app.log',
                'Console' => '@console/runtime/logs/app.log',
				'Api' => '@api/runtime/logs/app.log',
            ],
        ],
	],
];
