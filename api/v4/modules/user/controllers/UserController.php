<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\ActiveController as Controller;
use Yii;

/**
 * Class AuthController
 * @package api\v4\modules\user\controllers
 */
class UserController extends Controller
{

	public $serviceName = 'account.login';

	public function format() {
		return [
			'creation_date' => 'time:api',
			'birth_date' => 'time:api',
		];
	}

	/**
	 * @inheritdoc
	 */
	/*public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
		];
	}*/

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'view' => [
				'class' => 'common\ddd\rest\ViewAction',
				'service' => Yii::$app->account->login,
				'serviceMethod' => 'oneById',
			]
		];
	}

}