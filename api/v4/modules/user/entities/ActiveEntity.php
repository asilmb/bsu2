<?php

namespace api\v4\modules\user\entities;

use api\v4\modules\active\entities\ProviderEntity;
use api\v4\modules\active\entities\TypeEntity;
use common\ddd\BaseEntity;
use paulzi\jsonBehavior\JsonValidator;

class ActiveEntity extends BaseEntity {
	
	protected $id;
	protected $user_id;
	protected $active_id;
	protected $provider_id;
	protected $currency_code;
	protected $amount = 0;
	protected $data;
	protected $provider;
	protected $type;
	
	public function fieldType() {
		return [
			'provider' => [
				'type' => ProviderEntity::className(),
			],
			'type' => [
				'type' => TypeEntity::className(),
			],
		];
	}
	
	public function rules() {
		return [
			[['active_id', 'data', 'provider_id', 'currency_code'], 'required'],
			[['active_id', 'provider_id', 'currency_code'], 'integer'],
			[['data'], JsonValidator::className()],
		];
	}
	
}
