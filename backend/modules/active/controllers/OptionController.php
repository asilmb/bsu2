<?php
namespace backend\modules\active\controllers;

use api\v4\modules\active\forms\OptionForm;
use common\widgets\Alert;
use Yii;
use yii\web\Controller;

class OptionController extends Controller {
	
	public function actions() {
		return [
			'create' => [
				'class' => 'backend\modules\active\actions\CreateAction',
				'service' => Yii::$app->active->option,
				'form' => 'OptionForm',
				'model' => new OptionForm(),
				'view' => '/option'
			],
			'update' => [
				'class' => 'backend\modules\active\actions\UpdateAction',
				'service' => Yii::$app->active->option,
				'form' => 'OptionForm',
				'model' => new OptionForm(),
				'view' => '/option'
			],
			'delete' => [
				'class' => 'backend\modules\active\actions\DeleteAction',
				'service' => Yii::$app->active->option,
			],
		];
	}

	
}

