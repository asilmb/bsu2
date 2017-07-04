<?php

namespace common\ddd\traits;

trait ErrorTrait {
	
	protected $error = [];
	
	protected function addError($field, $message) {
		$this->error[] = [
			'field' => $field,
			'message' => $message,
		];
	}
	
	protected function addErrors($errors) {
		foreach($errors as $field => $messageList) {
			foreach($messageList as $message) {
				$this->addError($field, $message);
			}
		}
	}
	
	public function hasErrors() {
		return count($this->error);
	}
	
	public function getErrors() {
		return $this->error;
	}
	
}