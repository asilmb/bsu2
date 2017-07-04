<?php

namespace api\v4\modules\user\controllers;

use Yii;
use yii2lab\rest\rest\Controller;
use common\modules\user\forms\LoginForm;
use yii\helpers\ArrayHelper;

/**
 * Class AuthController
 * @package api\v4\modules\user\controllers
 */
class AuthController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
				'only' => ['info'],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'login' => ['POST'],
			'info' => ['GET'],
		];
	}

	public function actionLogin()
	{
		/** @var LoginForm $model */
		$model = Yii::createObject(LoginForm::className());
		$response = Yii::$app->getResponse();
		$body = Yii::$app->getRequest()->getBodyParams();
		if ($model->load($body, '') && $model->login()) {
			$response->setStatusCode(200);
			$responseBody = ArrayHelper::toArray(Yii::$app->user->identity);
			$responseBody['token'] = Yii::$app->user->identity->getAuthKey();
		} else {
			$response->setStatusCode(422);
			$responseBody = $model;
		}
		return $responseBody;
	}

	public function actionInfo()
	{
		return Yii::$app->user->identity;
	}
}