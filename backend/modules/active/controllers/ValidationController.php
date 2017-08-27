<?php
namespace backend\modules\active\controllers;

use api\v4\modules\active\forms\ValidationForm;
use Yii;
use yii\web\Controller;

class ValidationController extends Controller {
	
	public function actions() {
		return [
			'create' => [
				'class' => 'backend\modules\active\actions\CreateAction',
				'service' => Yii::$app->active->validation,
				'form' => 'ValidationForm',
				'model' => new ValidationForm(),
				'view' => '/validation',
			],
			'update' => [
				'class' => 'backend\modules\active\actions\UpdateAction',
				'service' => Yii::$app->active->validation,
				'form' => 'ValidationForm',
				'model' => new ValidationForm(),
				'view' => '/validation',
			],
			'delete' => [
				'class' => 'backend\modules\active\actions\DeleteAction',
				'service' => Yii::$app->active->validation,
			],
		];
	}
	
}

