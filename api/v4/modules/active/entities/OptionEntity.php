<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;

class OptionEntity extends BaseEntity {
	
	protected $id;
	public $field_id;
	protected $key;
	protected $title;
	
	public function rules() {
		return [
			[['field_id', 'key', 'title'], 'required'],
			[['field_id'], 'integer'],
		];
	}
}