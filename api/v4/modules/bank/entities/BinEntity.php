<?php

namespace api\v4\modules\bank\entities;

use api\v4\modules\active\entities\ProviderEntity;
use common\ddd\BaseEntity;

class BinEntity extends BaseEntity {
	
	public $bin;
	public $bank_id;
	protected $payment_system;
    protected $provider;
	
	public function fieldType() {
		return [
			'provider' => [
				'type' => ProviderEntity::className(),
			],
		];
	}
}
