<?php

namespace common\exceptions;

use Exception;
use yii\web\HttpException;

class ReadOnlyFieldException extends HttpException {
	
	public function __construct($field, $code = 0, Exception $previous = null) {
		parent::__construct(400, t('exception', 'read_only {field}', ['field' => $field]), $code, $previous);
	}
	
}
