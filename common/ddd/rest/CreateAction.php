<?php

namespace common\ddd\rest;

use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\base\Action;

class CreateAction extends Action {
	public $serviceMethod = 'create';
	public $successStatusCode = 201;
	public $service;
	
	public function run() {
		$body = Yii::$app->request->getBodyParams();
		$method = $this->serviceMethod;
		try {
			$this->service->$method($body);
		} catch(UnprocessableEntityHttpException $e) {
			Yii::$app->response->setStatusCode(422);
			return $e->getErrors();
		}
		Yii::$app->response->setStatusCode($this->successStatusCode);
		// todo: отдавайть ссылку на созданный ресурс
	}
}
