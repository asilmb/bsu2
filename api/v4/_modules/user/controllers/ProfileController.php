<?php

namespace api\v4\modules\user\controllers;

use Yii;
use yii2lab\rest\rest\ActiveController;
use yii\web\ForbiddenHttpException;

/**
 * Class ProfileController
 * @package api\v4\modules\user\controllers
 */
class ProfileController extends ActiveController
{
	
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		$this->modelClass = config('components.user.identityClass');
		parent::init();
	}
	
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
	
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		$userClass = config('components.user.identityClass');
		$actions = parent::actions();
		$actions['update-email'] = [
			'class' => 'yii2lab\rest\rest\UpdateAction',
			'modelClass' => $this->modelClass,
			'checkAccess' => [$this, 'checkAccess'],
			'scenario' => $userClass::SCENARIO_UPDATE_EMAIL,
			//'formClass' => $this->formClass,
		];
		$actions['update-password'] = [
			'class' => 'yii2lab\rest\rest\UpdateAction',
			'modelClass' => $this->modelClass,
			'checkAccess' => [$this, 'checkAccess'],
			'scenario' => $userClass::SCENARIO_UPDATE_PASSWORD,
			//'formClass' => $this->formClass,
		];
		$actions['update']['scenario'] = $userClass::SCENARIO_UPDATE;
		return $actions;
	}
	
	public function checkAccess($action, $model = null, $params = [])
	{
		if(Yii::$app->user->can('user.profile.*')) {
			return true;
		}
		if ($model->id !== Yii::$app->user->id) {
			throw new ForbiddenHttpException();
		}
	}
	
}