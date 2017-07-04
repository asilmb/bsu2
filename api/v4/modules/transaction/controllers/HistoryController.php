<?php

namespace api\v4\modules\transaction\controllers;

use yii2lab\rest\rest\Controller as Controller;
use api\v4\modules\transaction\helpers\HistoryHelper;
use yii\web\NotFoundHttpException;

class HistoryController extends Controller
{
 
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
	
	public function actionView($id) {
		$item = HistoryHelper::findOne($id);
		if(empty($item)) {
			throw new NotFoundHttpException();
		}
		return $item;
	}
	
	public function actionIndex() {
		$all = HistoryHelper::findAll();
		return $all->getDataProvider();
	}
	
	/** todo: create action for repeat payment */
	
}
