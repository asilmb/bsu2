<?php

namespace api\v4\modules\bank\entities;

use common\ddd\BaseEntity;

class CardEntity extends BaseEntity {

	protected $id;
	protected $hb_id;
	protected $mask;
	protected $approve;
	protected $reference;
	protected $bank;
	
	public function setId($value) {
		$this->id = intval($value);
	}
	
	public function setHbId($value) {
		$this->hb_id = intval($value);
	}
	
	public function setApprove($value) {
		$this->approve = boolval($value);
	}
	
	public function setBank($value) {
		$this->bank = new BankEntity($value);
	}
	
}
