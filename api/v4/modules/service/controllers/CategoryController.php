<?php

namespace api\v4\modules\service\controllers;

use yii2lab\rest\rest\ActiveController as Controller;

class CategoryController extends Controller
{
 
	public $modelClass = 'api\v4\modules\service\modelsDeco\Category';
	//public $updateScenario = Model::SCENARIO_UPDATE;
	//public $createScenario = Model::SCENARIO_CREATE;
	
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
