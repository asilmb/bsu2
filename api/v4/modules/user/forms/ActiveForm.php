<?php

namespace api\v4\modules\user\forms;

use common\base\Model;
use api\v4\modules\active\entities\ProviderEntity;
use paulzi\jsonBehavior\JsonValidator;

class ActiveForm extends Model{
	
	public $id;
	public $user_id;
	public $active_id;
	public $provider_id;
	public $currency_code;
	public $amount = 0;
	public $data;
	public $provider;
	public $type;
	
	public function fieldType() {
		return [
			'provider' => [
				'type' => ProviderEntity::className(),
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