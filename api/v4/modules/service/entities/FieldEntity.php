<?php

namespace api\v4\modules\service\entities;

use common\ddd\BaseEntity;

class FieldEntity extends BaseEntity {
	
	protected $id;
	protected $name;
	protected $title;
	protected $type;
	protected $mask;
	protected $value;
	protected $values;
	protected $min_length;
	protected $max_length;
	protected $validations;
	protected $translate;
	
	public function setMinLength($value) {
		$this->min_length = intval($value);
	}
	
	public function setMaxLength($value) {
		$this->max_length = intval($value);
	}
	
	public function getIsNeedSend() {
		return empty($this->name == 'txn_id' || $this->name == 'button' || $this->name == 'capcha');
	}

	public function hideIfNullFields() {
		return true;
	}
	
	public function fields() {
		$fields = parent::fields();
		$fields['is_need_send'] = 'is_need_send';
		return $fields;
	}
}
