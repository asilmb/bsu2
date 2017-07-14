<?php

namespace api\v4\modules\service\controllers;

use yii2lab\rest\rest\ActiveController as Controller;
use yii2lab\misc\yii\base\Model;

class FavoriteController extends Controller
{
 
	public $modelClass = 'api\v4\modules\service\modelsDeco\Favorite';
	public $formClass = 'api\v4\modules\service\forms\ServiceFavoriteForm';
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
			],
		];
	}
	
}
