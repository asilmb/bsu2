<?php

namespace api\v4\modules\card\services\card;

use common\services\BaseEntity;

class Entity extends BaseEntity {

	public $id;
	public $hb_id;
	public $mask;
	public $approve = false;
	public $reference;
	public $bank;
	
	public function approve($reference) {
		if(!empty($this->reference)) {
			$this->addError('reference', 'already approved');
			return false;
		}
		$this->reference = $reference;
		return $this->validate();
	}
	
	public function rules()
	{
		return [
			[['id', 'hb_id', 'mask'], 'required'],
			[['mask', 'reference'], 'trim'],
			[['mask', 'reference'], 'string', 'min' => 2],
			[['id', 'hb_id'], 'integer'],
		];
	}
	
}
