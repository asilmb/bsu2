<?php

namespace api\v4\modules\geo\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;

class RegionController extends Controller
{
	
	public $serviceName = 'geo.region';

	public function format() {
		return [
			'country' => [
				'date_change' => 'time:api',
			],
			'cities' => [
				'date_change' => 'time:api',
			],
		];
	}

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
						'roles' => ['geo.region.manage'],
					],
				],
			],
		];
	}
	
}
