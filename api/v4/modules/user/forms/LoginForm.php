<?php

namespace api\v4\modules\user\forms;

use api\v4\modules\user\helpers\LoginHelper;
use yii\base\Model;


class LoginForm extends Model
{
	public $login;
	public $password;
	public $rememberMe = true;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['login', 'password'], 'trim'],
			[['login', 'password'], 'required'],
			'normalizeLogin' => ['login', 'normalizeLogin'],
			[['password'], 'string', 'min' => 8],
			['rememberMe', 'boolean'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'login' 		=> t('user/main', 'login'),
			'password' 		=> t('user/main', 'password'),
			'rememberMe' 		=> t('user/auth', 'remember_me'),
		];
	}

	public function normalizeLogin($attribute)
	{
		$this->$attribute = LoginHelper::pregMatchLogin($this->$attribute);
	}
	
	public function addErrorsFromException($e) {
		foreach($e->getErrors() as $error) {
			if(!empty($error)) {
				$this->addError($error['field'], $error['message']);
			}
		}
	}
}
