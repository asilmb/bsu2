<?php

namespace common\ddd\rest;

use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\base\Action;

class UpdateAction extends Action {
	public $serviceMethod = 'update';
	public $successStatusCode = 204;
	public $service;
	
	public function run($id) {
		$body = Yii::$app->request->getBodyParams();
		$method = $this->serviceMethod;
		try {
			$this->service->$method($id, $body);
		} catch(UnprocessableEntityHttpException $e) {
			Yii::$app->response->setStatusCode(422);
			return $e->getErrors();
		}
		Yii::$app->response->setStatusCode($this->successStatusCode);
	}
}
