<?php

namespace backend\modules\content\actions;

use common\widgets\Alert;
use yii\base\Action;

class DeleteAction extends Action {
	
	public $serviceMethod = 'deleteById';
	public $service;
	
	//todo решить проблему с редиректом
	public function run($id) {
		$returnUrl = '/news';
		$method = $this->serviceMethod;
		$this->service->$method($id);
		Alert::add(['content/news', 'update_success'], Alert::TYPE_SUCCESS);
		return $this->controller->redirect($returnUrl);
	}
}
