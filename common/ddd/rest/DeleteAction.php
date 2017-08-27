<?php

namespace common\ddd\rest;

use Yii;
use Exception;
use yii\base\Action;

class DeleteAction extends Action {
	public $serviceMethod = 'delete';
	public $service;
	
	public function run($id) {
		$method = $this->serviceMethod;
		$this->service->$method($id);
		Yii::$app->response->setStatusCode(204);
	}
}
