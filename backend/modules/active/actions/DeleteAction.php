<?php

namespace backend\modules\active\actions;

use common\widgets\Alert;
use yii\base\Action;

class DeleteAction extends Action {
	public $serviceMethod = 'deleteById';
	public $service;
	//todo решить проблему с редиректом
	public function run($id) {
		$thisEntity = $this->service->oneById($id);
		$returnUrl = '/active';
		if (!empty($thisEntity->active_id)) {
			$returnUrl = '/active/view?id=' . $thisEntity->active_id;
		}
		if (!empty($thisEntity->field_id)) {
			$returnUrl = '/active/field/view?id=' . $thisEntity->field_id;
		}
		$method = $this->serviceMethod;
		$this->service->$method($id);
		Alert::add(['active/type', 'delete_success'], Alert::TYPE_SUCCESS);
		return $this->controller->redirect($returnUrl);
	}
}
