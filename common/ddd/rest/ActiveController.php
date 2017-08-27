<?php

namespace common\ddd\rest;

use Yii;

class ActiveController extends Controller {
	
	public $usePagination = true;
	
	public function actions() {
		return [
			'index' => [
				'class' => 'common\ddd\rest\IndexAction',
				'service' => $this->service,
				'serviceMethod' => !empty($this->usePagination) ? 'getDataProvider' : 'findAll',
			],
			'create' => [
				'class' => 'common\ddd\rest\CreateAction',
				'service' => $this->service,
			],
			'view' => [
				'class' => 'common\ddd\rest\ViewAction',
				'service' => $this->service,
			],
			'update' => [
				'class' => 'common\ddd\rest\UpdateAction',
				'service' => $this->service,
			],
			'delete' => [
				'class' => 'common\ddd\rest\DeleteAction',
				'service' => $this->service,
			],
		];
	}
	
	protected function verbs() {
		return [
			'index' => ['GET', 'HEAD'],
			'view' => ['GET', 'HEAD'],
			'create' => ['POST'],
			'update' => ['PUT', 'PATCH'],
			'delete' => ['DELETE'],
			'options' => ['OPTIONS'],
		];
	}
	
	public function actionOptions() {
		if(Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
			Yii::$app->getResponse()->setStatusCode(405);
		}
		//Yii::$app->getResponse()->getHeaders()->set('Allow',['DELETE']);
	}
}
