<?php

namespace api\v4\modules\transaction\entities;

use common\ddd\BaseEntity;

class DebtEntity extends BaseEntity {

	protected $id;
	protected $address;
	protected $account;
	protected $serviceId; //int
	protected $commission; //int
	protected $invoices;

	public function getInvoices() {
		return $this->invoices;
	}

	public function setInvoices($value) {
		if(empty($value)) {
			return [];
		}
		foreach($value as $item) {
			$this->invoices[] = new InvoiceEntity($item);
		}
	}

}
