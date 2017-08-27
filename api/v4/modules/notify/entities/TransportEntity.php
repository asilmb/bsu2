<?php

namespace api\v4\modules\notify\entities;

use common\ddd\BaseEntity;

class TransportEntity extends BaseEntity {

	const TYPE_SMS = 'sms';
	const TYPE_EMAIL = 'email';

	protected $id;
	protected $type;
	protected $subject;
	protected $message;
	protected $address;
	protected $created_at;

	public function rules() {
		$types = $this->getConstantEnum('type');
		return [
			[['type', 'subject', 'message', 'address'], 'trim'],
			[['type', 'message', 'address'], 'required'],
			[['type'], 'in', 'range' => $types],
		];
	}

}
