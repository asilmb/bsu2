<?php

namespace api\v4\modules\active\services;

use common\ddd\services\ActiveBaseService;

class ValidationService extends ActiveBaseService {
	
	public $foreignServices = [
		'active.field' => [
			'field' => 'field_id',
			'notFoundMessage' => ['active/field', 'not_found'],
		],
	];
	
}
