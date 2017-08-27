<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\Controller as Controller;
use yii\filters\VerbFilter;

/**
 * Class AuthController
 * @package api\v4\modules\user\controllers
 */
class SecurityController extends Controller
{

	public $serviceName = 'account.security';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
			'verbFilter' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'email' => ['PUT'],
					'password' => ['PUT'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		$actions = parent::actions();
		$actions['email'] = [
			'class' => 'common\ddd\rest\UniAction',
			'successStatusCode' => 204,
			'service' => $this->service,
			'serviceMethod' => 'changeEmail',
		];
		$actions['password'] = [
			'class' => 'common\ddd\rest\UniAction',
			'successStatusCode' => 204,
			'service' => $this->service,
			'serviceMethod' => 'changePassword',
		];
		return $actions;
	}

}