<?php

namespace common\exceptions;

use Exception;
use yii\web\HttpException;

class ModifyProtectFieldException extends HttpException {
	
	public function __construct($field, $code = 0, Exception $previous = null) {
		parent::__construct(400, t('exception', 'modify_protect {field}', ['field' => $field]), $code, $previous);
	}
	
}
