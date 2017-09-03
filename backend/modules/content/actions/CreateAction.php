<?php

namespace backend\modules\content\actions;

use common\widgets\Alert;
use Yii;
use yii\base\Action;

class CreateAction extends Action {
	public $service;
	public $model;
	public $form;
	public $view;
	
	public function run() {
		$model = $this->model;
		$body = Yii::$app->request->getBodyParam($this->form);
		$returnUrl ='/news';
	
		$isValid = $model->load($body, '') && $model->validate();
		if ($isValid) {
			$this->service->create($body);
			Alert::add(['content/news', 'update_success'], Alert::TYPE_SUCCESS);
			return $this->controller->redirect($returnUrl);
		};
		return $this->controller->render($this->view . '/create', ['model' => $model]);
	}
}
