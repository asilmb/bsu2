<?php

namespace api\v4\modules\geo\repositories\ar;

use common\ddd\data\Query;
use common\ddd\repositories\ActiveArRepository;

class CityRepository extends ActiveArRepository {
	
	public function uniqueFields() {
		return [
			['city_name'],
		];
	}
	
	public function allByRegionId($regionId) {
		$query = new Query();
		$query->where('region_id', $regionId);
		
		return $this->all($query);
	}
	
}
