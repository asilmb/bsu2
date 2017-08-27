<?php

namespace api\v4\modules\bank\controllers;

use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use common\ddd\rest\ActiveControllerWithQuery as Controller;
use yii\filters\VerbFilter;

class CardController extends Controller
{
 
	public $serviceName = 'bank.card';
	public $usePagination = false;
	
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
				'actions' => $this->verbs(),
			],
		];
	}

	public function actions() {
		$actions = parent::actions();
		$actions['index']['serviceMethod'] = 'all';
		return $actions;
	}

	protected function verbs()
	{
		return [
			'index' => ['GET', 'HEAD'],
			'view' => ['GET', 'HEAD'],
			'approve' => ['PUT'],
			'delete' => ['DELETE'],
		];
	}

	public function actionApprove()
	{
		$body = Yii::$app->request->getBodyParams();
		try {
			$this->service->approve($body);
		} catch(UnprocessableEntityHttpException $e) {
			Yii::$app->response->setStatusCode(422);
			return $e->getErrors();
		}
		Yii::$app->response->setStatusCode(204);
	}
	
}
