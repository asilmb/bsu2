<?php

namespace api\v4\modules\geo\services;

use common\ddd\data\Query;
use common\ddd\services\ActiveBaseService;

class RegionService extends ActiveBaseService {
	
	//public $forbiddenChangeFields = ['active_id'];
	public $foreignServices = [
		'geo.country' => [
			'field' => 'country_id',
			'notFoundMessage' => ['active/country', 'not_found'],
		],
	];
	
	public function allByCountryId($countryId){
		$query = new Query;
		$query->where('country_id', $countryId);
		return $this->repository->all($query);
		
	}
	
	
}
