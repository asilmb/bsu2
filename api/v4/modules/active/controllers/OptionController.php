<?php

namespace api\v4\modules\active\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;

class OptionController extends Controller
{
	
	public $serviceName = 'active.option';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
				'only' => ['create', 'update', 'delete'],
			],
			'access' => [
				'class' => 'yii\filters\AccessControl',
				'only' => ['create', 'update', 'delete'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['active.field.manage'],
					],
				],
			],
		];
	}
	
}
