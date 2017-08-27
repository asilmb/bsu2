<?php

namespace common\ddd\rest;

use Yii;
use Exception;
use yii\base\Action;

class ViewAction extends Action {
	public $serviceMethod = 'findOne';
	public $service;
	
	public function run($id) {
		$params = Yii::$app->request->get();
		$method = $this->serviceMethod;
		return $this->service->$method($id, $params);
	}
}
