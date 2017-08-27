<?php

namespace api\v4\modules\user\forms;

use api\v4\modules\user\validators\LoginValidator;
use common\base\Model;

class RestorePasswordForm extends Model {
	
	public $login;
	public $activation_code;
	public $password;
	
	const SCENARIO_REQUEST = 'request';
	const SCENARIO_CHECK = 'check';
	const SCENARIO_CONFIRM = 'confirm';
	
	public function rules() {
		return [
			[['login', 'password', 'activation_code'], 'trim'],
			[['login', 'password', 'activation_code'], 'required'],
			['login', LoginValidator::className()],
			[['activation_code'], 'integer'],
			[['activation_code'], 'string', 'length' => 6],
			[['password'], 'string', 'min' => 8],
		];
	}
	
	public function scenarios() {
		return [
			self::SCENARIO_REQUEST => ['login'],
			self::SCENARIO_CHECK => ['login', 'activation_code'],
			self::SCENARIO_CONFIRM => ['login', 'activation_code', 'password'],
		];
	}
	
}
