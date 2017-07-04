<?php

namespace common\services;

use yii\base\Model;

class Condition {
	
	protected $condition = [];
	
	public function add() {
		$this->condition[] = func_get_args();
	}
	
	public function get() {
		return $this->condition;
	}
	
}