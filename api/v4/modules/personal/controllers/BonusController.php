<?php

namespace api\v4\modules\personal\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;
use Yii;

class BonusController extends Controller
{
	public $serviceName = 'personal.bonus';
	public $usePagination = false;
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
