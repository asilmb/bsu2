<?php

namespace api\v4\modules\geo\entities;

use common\ddd\BaseEntity;

class CityEntity extends BaseEntity {
	
	protected $id;
	protected $id_country;
	protected $region_id;
	protected $city_name;
	protected $position;
	protected $status;
	protected $date_change;
	protected $country;
	protected $region;

	public function rules() {
		return [
			[['id', 'id_country', 'city_name'], 'required'],
			//[['id', 'city_name'], 'unique'],
			[['city_name'], 'trim'],
			['city_name', 'string', 'min' => 2],
			[['id', 'id_country', 'region_id', 'position', 'status'], 'integer'],
		];
	}
	
}