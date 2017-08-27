<?php

namespace api\v4\modules\transaction\entities;

use common\ddd\BaseEntity;

class PaymentCheckEntity extends BaseEntity {
	
	protected $service_id;
	protected $fields;
	
	function setServiceId($value) {
		$this->service_id = intval($value);
	}
	
	function setFields($value) {
		$value['serviceId'] = $this->service_id;
		$this->fields = new PaymentCheckFieldsEntity($value);
	}
	
}
