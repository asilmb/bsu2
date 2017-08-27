<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\Controller;
use yii\filters\Cors;

class RegistrationController extends Controller
{
	public $serviceName = 'account.registration';
	
	public function behaviors() {
		return [
			'corsFilter' => [
				'class' => Cors::className(),
			],
		];
	}
	
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
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'create-account' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 201,
				'serviceMethod' => 'createTempAccount',
				'serviceMethodParams' => ['login', 'email'],
			],
			'activate-account' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 201,
				'serviceMethod' => 'checkActivationCode',
				'serviceMethodParams' => ['login', 'activation_code'],
			],
			'set-password' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 201,
				'serviceMethod' => 'createTpsAccount',
				'serviceMethodParams' => ['login', 'activation_code', 'password'],
			],
		];
	}

}