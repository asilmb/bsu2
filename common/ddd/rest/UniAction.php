<?php

namespace common\ddd\rest;

use common\exceptions\UnprocessableEntityHttpException;
use Yii;

use yii\base\Action;
use yii\helpers\ArrayHelper;

class UniAction extends Action {
	public $serviceMethod = 'update';
	public $serviceMethodParams = [];
	public $successStatusCode = 200;
	public $service;
	
	public function run() {
		try {
			$response = $this->runServiceMethod();
		} catch(UnprocessableEntityHttpException $e) {
			Yii::$app->response->setStatusCode(422);
			return $e->getErrors();
		}
		Yii::$app->response->setStatusCode($this->successStatusCode);
		if(!empty($response)) {
			return $response;
		}
		return [];
	}
	
	protected function runServiceMethod() {
		$body = Yii::$app->request->getBodyParams();
		$method = $this->serviceMethod;
		if(empty($this->serviceMethodParams)) {
			$response = $this->service->$method($body);
		} else {
			$response = call_user_func_array([$this->service, $method], $this->getParams($body));
		}
		return $response;
	}
	
	protected function getParams($body) {
		$params = [];
		foreach($this->serviceMethodParams as $paramName) {
			$params[] = ArrayHelper::getValue($body, $paramName);
		}
		return $params;
	}
}
