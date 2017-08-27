<?php

namespace api\v4\modules\service\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;

class FavoriteController extends Controller
{
	
	public $serviceName = 'service.favorite';
	
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
	
}
