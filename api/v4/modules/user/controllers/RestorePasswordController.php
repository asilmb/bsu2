<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\Controller;

class RestorePasswordController extends Controller
{
	public $serviceName = 'account.restorePassword';
	
	/**
	 * @inheritdoc
	 */
	protected function verbs()
	{
		return [
			'request' => ['POST'],
			'check-code' => ['POST'],
			'confirm' => ['POST'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'request' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 201,
				'serviceMethod' => 'request',
				'serviceMethodParams' => ['login'],
			],
			'check-code' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 204,
				'serviceMethod' => 'checkActivationCode',
				'serviceMethodParams' => ['login', 'activation_code'],
			],
			'confirm' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 204,
				'serviceMethod' => 'confirm',
				'serviceMethodParams' => ['login', 'activation_code', 'password'],
			],
		];
	}

}