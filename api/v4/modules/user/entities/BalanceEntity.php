<?php

namespace api\v4\modules\user\entities;

use common\ddd\BaseEntity;

class BalanceEntity extends BaseEntity {

	protected $blocked;
	protected $active;
	protected $pay_delayed;
	protected $acc_base;
	protected $acc_commission;
	
	public function getblocked() {
		return floatval($this->blocked);
	}

	public function getActive() {
		return floatval($this->active);
	}

	public function getPayDelayed() {
		return floatval($this->pay_delayed);
	}

	public function getAccBase() {
		return floatval($this->acc_base);
	}

	public function getAccCommission() {
		return floatval($this->acc_commission);
	}

}
