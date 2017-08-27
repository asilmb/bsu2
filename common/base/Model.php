<?php

namespace common\base;

use yii\base\Model as YiiModel;
use yii\helpers\ArrayHelper;

class Model extends YiiModel
{
	public function loadAttributes($data) {
	
	}
	
	public function addErrorsFromException($e) {
		$errors = $e->getErrors();
		if($errors instanceof YiiModel) {
			$errors = $errors->getErrors();
		}
		foreach($errors as $field => $error) {
			if(ArrayHelper::isIndexed($error)) {
				foreach ($error as $message) {
					$this->addError($field, $message);
				}
				
			} else {
				$this->addError($error['field'], $error['message']);
			}
		}
	}
}
