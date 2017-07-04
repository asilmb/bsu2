<?php

namespace common\yii\base;

use Yii;
use yii\base\Model as YiiModel;
use yii\db\BaseActiveRecord;

class Model extends YiiModel
{

	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';
	
	protected function saveModel($model)
	{
		$saveResult = $model->save();
		if($model->hasErrors() || !$saveResult) {
			$this->addErrors($model->getErrors());
		}
		return $saveResult ? $model : null;
	}
	
	protected function loadModel($id = null, $modelClass = null)
	{
		/** @var BaseActiveRecord $modelClass */
		if(empty($modelClass)) {
			$modelClass = $this->modelClass();
		}
		if($id) {
			$model = $modelClass::findOne($id);
		} else {
			$model = new $modelClass();
		}
		//$model->load($this->attributes, '');
		return $model;
	}
	
}
