<?php

namespace api\v4\modules\user\entities;

use common\ddd\BaseEntity;

class CarEntity extends BaseEntity {
	
	protected $login;
	protected $gov_number;
	protected $document_number;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['gov_number', 'document_number'], 'trim'],
			['gov_number', 'string', 'max' => 10],
			['document_number', 'string', 'max' => 16],
		];
	}
	
}
