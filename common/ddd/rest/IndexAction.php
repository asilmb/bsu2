<?php

namespace common\ddd\rest;

use Yii;
use Exception;
use yii\base\Action;

class IndexAction extends Action {
	public $serviceMethod = 'getDataProvider';
	public $service;
	
	public function run() {
		$params = Yii::$app->request->get();
		$method = $this->serviceMethod;
		return $this->service->$method($params);
	}
}
