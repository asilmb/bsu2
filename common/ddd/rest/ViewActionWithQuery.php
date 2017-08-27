<?php

namespace common\ddd\rest;

use common\ddd\data\GetParams;
use Yii;
use yii\base\Action;

class ViewActionWithQuery extends Action {
	public $serviceMethod = 'oneById';
	public $service;
	
	public function run($id) {
		$query = $this->getQuery();
		$method = $this->serviceMethod;
		return $this->service->$method($id, $query);
	}
	
	private function getQuery() {
		$params = Yii::$app->request->get();
		$getParams = new GetParams();
		return $getParams->getAllParams($params);
	}
}
