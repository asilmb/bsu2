<?php

namespace api\v4\modules\user\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;
use Yii;

class ActiveController extends Controller
{
	
	public $serviceName = 'account.active';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
		];
	}
	
	public function actions() {
		$actions = parent::actions();
		$actions['update']['serviceMethod'] = 'updateDataById';
		$actions['create']['serviceMethod'] = 'createData';
		return $actions;
	}

}
