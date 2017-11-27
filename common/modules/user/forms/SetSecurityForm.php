<?php

namespace common\modules\user\forms;

use common\base\Model;

class SetSecurityForm extends Model
{
	
	public $email;
	public $password;
	public $password_repeat;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['email',  'password', 'password_repeat'], 'trim'],
			[['email',  'password', 'password_repeat'], 'required'],
			['email', 'email'],
			['password', 'string', 'min' => 6],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'password' 		=> t('user/main', 'password'),
			'password_repeat' 		=> t('user/main', 'password_repeat'),
			'email' 		=> t('user/main', 'email'),
		];
	}
	
}
