<?php

namespace common\services;

use yii\base\Model;
use yii2mod\helpers\ArrayHelper;

class ErrorCollection extends Model {
	
	public $errorList = [];
	
	public function add(ErrorEntity $error) {
		$this->errorList[] = $error;
	}
	
	public function getAll() {
		return $this->errorList;
	}
	
	public function getFirst() {
		return ArrayHelper::first($this->errorList);
	}
	
	public function clear() {
		$this->errorList = [];
	}
	
	public function count() {
		return count($this->errorList);
	}
	
}