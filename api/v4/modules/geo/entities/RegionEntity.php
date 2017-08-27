<?php

namespace api\v4\modules\geo\entities;

use common\ddd\BaseEntity;

class RegionEntity extends BaseEntity {
	
	protected $id;
	protected $country_id;
	protected $title;
	protected $country;
	protected $cities;
	
	public function rules() {
		return [
			[['title'], 'trim'],
			[['title', 'country_id'], 'required'],
			[['country_id'], 'integer'],
		];
	}
	
}