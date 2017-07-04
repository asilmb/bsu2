<?php

namespace api\v4\modules\user\controllers;

use Yii;
use yii2lab\rest\rest\Controller;
use api\v4\modules\user\forms\RegistrationForm;

/**
 * Class RegistrationController
 * @package api\v4\modules\user\controllers
 */
class RegistrationController extends Controller
{
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'create-account' => ['POST'],
			'activate-account' => ['POST'],
			'set-password' => ['POST'],
		];
	}

	public function actionCreateAccount()
	{
		return $this->commonAction(RegistrationForm::SCENARIO_CREATE_ACCOUNT);
	}

	public function actionActivateAccount()
	{
		return $this->commonAction(RegistrationForm::SCENARIO_ACTIVATE_ACCOUNT);
	}
	
	public function actionSetPassword()
	{
		return $this->commonAction(RegistrationForm::SCENARIO_SET_PASSWORD);
	}
	
	protected function commonAction($scenario)
	{
		/** @var RegistrationForm $model */
		$model = $this->createForm($scenario);
		if ($model->save()) {
			Yii::$app->response->setStatusCode(201);
		} else {
			if($model->hasErrors()) {
				Yii::$app->response->setStatusCode(422);
				return $model;
			} else {
				Yii::$app->response->setStatusCode(500);
			}
		}
		return null;
	}
	
	protected function createForm($scenario)
	{
		/** @var RegistrationForm $model */
		$model = Yii::createObject(RegistrationForm::className());
		$model->scenario = $scenario;
		$body = Yii::$app->request->getBodyParams();
		$model->load($body, '');
		return $model;
	}
}