<?php

namespace api\v4\modules\transaction\entities;

use common\ddd\BaseEntity;

class InvoiceEntity extends BaseEntity {

	protected $invoiceId;
	protected $formedDate;
	protected $expireDate;
	protected $services;

	/*public function getServices() {
		return $this->services;
	}

	public function setServices($value) {
		if(empty($value)) {
			return [];
		}
		foreach($value as $item) {
			$this->services[] = new ServiceEntity($item);
		}
	}*/

}
