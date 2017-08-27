<?php

namespace api\v4\modules\geo\entities;

use common\ddd\BaseEntity;

class CountryEntity extends BaseEntity {
	
	protected $code;
	protected $name_short;
	protected $name_full;
	protected $symb_def2;
	protected $symb_def3;
	protected $code_curr;
	protected $date_change;
	protected $currency;
	protected $cities;
	protected $regions;

	public function rules() {
		return [
			[['code', 'name_short', 'name_full', 'symb_def2', 'symb_def3'], 'required'],
			//[['code', 'name_short', 'name_full', 'symb_def2', 'symb_def3', 'code_curr'], 'unique'],
			[['name_short', 'name_full', 'symb_def2', 'symb_def3'], 'trim'],
			[['name_short', 'name_full', 'symb_def2', 'symb_def3'], 'string', 'min' => 2],
			[['code', 'code_curr'], 'integer'],
		];
	}
	
}