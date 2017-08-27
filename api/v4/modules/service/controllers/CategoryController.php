<?php

namespace api\v4\modules\service\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;

class CategoryController extends Controller
{
	
	public $serviceName = 'service.category';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
				'only' => ['create', 'update', 'delete'],
			],
			'access' => [
				'class' => 'yii\filters\AccessControl',
				'only' => ['create', 'update', 'delete'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['service.category.manage'],
					],
				],
			],
		];
	}

}
