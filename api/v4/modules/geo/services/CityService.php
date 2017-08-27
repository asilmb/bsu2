<?php

namespace api\v4\modules\geo\services;

use common\ddd\data\Query;
use common\ddd\services\ActiveBaseService;

class CityService extends ActiveBaseService {
	
	public $foreignServices = [
		'geo.country' => [
			'field' => 'id_country',
			'notFoundMessage' => ['geo/country', 'not_found'],
		],
	];
	
	public function allByRegionId($regionId) {
		return $this->repository->allByRegionId($regionId);
	}
	
}
