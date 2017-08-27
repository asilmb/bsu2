<?php

namespace api\v4\modules\content\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;

class NewsController extends Controller
{
	
	public $serviceName = 'content.news';
	
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
						'roles' => ['balhash.admin'],
					],
				],
			],
		];
	}
	
}
