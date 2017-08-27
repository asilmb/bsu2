<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\Controller;

class CarController extends Controller
{

	public $serviceName = 'account.car';

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
	public function actions() {
		return [
			'view' => [
				'class' => 'common\ddd\rest\IndexActionWithQuery',
				'service' => $this->service,
				'serviceMethod' => 'getSelf',
			],
			'update' => [
				'class' => 'common\ddd\rest\CreateAction',
				'service' => $this->service,
				'serviceMethod' => 'updateSelf',
				'successStatusCode' => 204,
			],
		];
	}

}