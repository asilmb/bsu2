<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\Controller;
use Yii;

/**
 * Class AuthController
 * @package api\v4\modules\user\controllers
 */
class AuthController extends Controller
{

	public $serviceName = 'account.auth';

	public function format() {
		return [
			'profile' => [
				'sex' => 'boolean',
				'birth_date' => 'time:api',
			],
		];
	}

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

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'login' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'authentication',
				'serviceMethodParams' => ['login', 'password'],
			],
			'info' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => Yii::$app->user,
				'successStatusCode' => 200,
				'serviceMethod' => 'getIdentity',
			],
		];
	}

}