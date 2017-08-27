<?php

namespace api\v4\modules\geo\services;

use common\ddd\services\ActiveBaseService;

class CountryService extends ActiveBaseService {
	
	public $foreignServices = [
		'geo.currency' => [
			'field' => 'code',
			'notFoundMessage' => ['geo/currency', 'not_found'],
			'isChild' => true,
		],
	];
	
}
