<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;

class ValidationEntity extends BaseEntity {
	
	const TYPE_NUMERICAL = 'numerical';
	const TYPE_REQUIRED = 'required';
	const TYPE_COMPARE = 'compare';
	const TYPE_CUSTOM = 'custom';
	const TYPE_LENGTH = 'length';
	const TYPE_MATCH = 'match';
	const TYPE_STRING = 'string';
	//const TYPE_TYPE = 'type';

	protected $id;
	public $field_id;
	protected $type;
	protected $rules;
	
	public function rules() {
		$types = $this->getConstantEnum('type');
		return [
			[['field_id', 'type'], 'required'],
			[['field_id'], 'integer'],
			[['type'], 'in', 'range' => $types],
		];
	}
	
	/**
	 * @return mixed
	 */
	public function getRules() {
		if(empty($this->rules) ){
			return null;
		}
		return $this->rules;
	}
	
}
