<?php

namespace api\v4\modules\transfer\forms;

use api\v4\modules\user\validators\LoginValidator;
use yii2lab\misc\yii\base\Model;

/**
 * Login form
 */
class DefaultForm extends Model {
	public $from;
	public $to;
	
	const SCENARIO_WALLET_WALLET = 'wallet-wallet';
	//const SCENARIO_CHECK = 'check';
	//const SCENARIO_CONFIRM = 'confirm';
	
	public function rules() {
		return [
			[['from', 'to'], 'trim'],
			[['from', 'to'], 'required'],
			[['from', 'to'], LoginValidator::className()],
		];
	}
	
	public function scenarios() {
		return [
			self::SCENARIO_WALLET_WALLET => ['from', 'to'],
		];
	}
}
