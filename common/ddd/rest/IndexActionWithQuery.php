<?php

namespace common\ddd\rest;

use common\ddd\data\GetParams;
use Yii;
use yii\base\Action;
use common\ddd\data\Query;

class IndexActionWithQuery extends Action {
	public $serviceMethod = 'getDataProvider';
	public $service;
	
	public function run() {
		$query = $this->getQuery();
		$method = $this->serviceMethod;
		return $this->service->$method($query);
	}
	
	private function getQuery() {
		$params = Yii::$app->request->get();
		$getParams = new GetParams();
		return $getParams->getAllParams($params);
	}
}
