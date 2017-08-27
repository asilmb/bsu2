<?php

namespace api\v4\modules\user\forms;

use api\v4\modules\user\validators\LoginValidator;

class RegistrationForm extends RestorePasswordForm {
	
	public $login;
	public $activation_code;
	public $password;
	public $email;
	
	const SCENARIO_REQUEST = 'request';
	const SCENARIO_CHECK = 'check';
	const SCENARIO_CONFIRM = 'confirm';
	
	public function rules() {
		return [
			[['login', 'password', 'activation_code', 'email'], 'trim'],
			[['login', 'password', 'activation_code'], 'required'],
			['login', LoginValidator::className()],
			['email', 'email'],
			[['activation_code'], 'integer'],
			[['activation_code'], 'string', 'length' => 6],
			[['password'], 'string', 'min' => 8],
		];
	}
	
	public function scenarios() {
		return [
			self::SCENARIO_REQUEST => ['login', 'email'],
			self::SCENARIO_CHECK => ['login', 'activation_code'],
			self::SCENARIO_CONFIRM => ['login', 'activation_code', 'password'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'login' 		=> t('user/main', 'login'),
			'email' 		=> t('user/main', 'email'),
			'activation_code' 		=> t('user/main', 'activation_code'),
		];
	}
	
}
