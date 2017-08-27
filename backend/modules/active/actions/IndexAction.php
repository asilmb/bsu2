<?php

namespace backend\modules\active\actions;

use Yii;
use yii\base\Action;
use yii\data\ArrayDataProvider;

class IndexAction extends Action {
	public $service;
	public $view;
	
	public function run() {
		$dataProvider = new ArrayDataProvider([
			'allModels' => $this->service->all(),
			'sort' => [
				'attributes' => ['id'],
			],
			'pagination' => [
				'pageSize' => Yii::$app->params['pageSize'],
			],
		]);
		return $this->controller->render($this->view . '/index', [
			'dataProvider' => $dataProvider,
		]);
	}
}
