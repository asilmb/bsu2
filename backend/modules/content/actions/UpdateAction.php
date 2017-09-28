<?php

namespace backend\modules\content\actions;

use common\widgets\Alert;
use Yii;
use yii\base\Action;

class UpdateAction extends Action {
	public $service;
	public $model;
	public $form;
	public $view;
	
	
	public function run($id) {
		$body = Yii::$app->request->getBodyParam($this->form);
		if (!empty($body)) {
			$returnUrl = $this->view;
			$this->service->updateById($id, $body);
			Alert::add(['content/news', 'update_success'], Alert::TYPE_SUCCESS);
			return $this->controller->redirect($returnUrl);
		}
		
		$model = $this->model;
		$entity = $this->service->oneById($id);
		$model->setAttributes($entity->toArray(),false);
		return $this->controller->render($this->view . '/update', ['model' => $model]);
	}
}
