<?php

namespace api\v4\modules\service\entities;

use common\ddd\BaseEntity;

class FieldsEntity extends BaseEntity {

	protected $name;
	protected $title;
	protected $type;
	protected $mask;
	protected $value;
	protected $values;
	protected $min_length;
	protected $max_length;

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
