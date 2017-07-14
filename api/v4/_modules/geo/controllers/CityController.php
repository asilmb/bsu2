<?php

namespace api\v4\modules\geo\controllers;

use yii2lab\rest\rest\ActiveController as Controller;
use yii2lab\misc\yii\base\Model;

class CityController extends Controller
{
 
	public $modelClass = 'api\v4\modules\geo\modelsDeco\City';
	//public $formClass = 'api\v4\modules\geo\forms\CityForm';
	public $updateScenario = Model::SCENARIO_UPDATE;
	public $createScenario = Model::SCENARIO_CREATE;
	
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
						'roles' => ['geo.city.manage'],
					],
				],
			],
		];
	}
	
}
