<?php

namespace common\exceptions;

use common\ddd\helpers\ErrorCollection;
use Exception;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class UnprocessableEntityHttpException extends HttpException {
	
	private $errors = [];
	
	public function __construct($errors = [], $code = 0, Exception $previous = null) {
		$message = '';
		if (!empty($errors)) {
			$message = json_encode(ArrayHelper::toArray($errors));;
		}
		parent::__construct(422, $message, $code, $previous);
		$this->setErrors($errors);
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	private function setErrors($errors) {
		if ($errors instanceof ErrorCollection) {
			$errors = $errors->all();
		}
		$this->errors = $errors;
	}
}
