<?php

namespace api\v4\modules\bank\entities;

use common\ddd\BaseEntity;

class BankEntity extends BaseEntity {
	
	public $id;
	protected $code;
	protected $bik;
	public $name;
	protected $bin;
	protected $picture;
	
	public function setId($value) {
		$this->id = intval($value);
	}
	
	public function setCode($value) {
		$this->code = intval($value);
	}
	
}
