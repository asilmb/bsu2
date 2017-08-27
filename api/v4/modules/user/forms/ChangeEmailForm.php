<?php

namespace api\v4\modules\user\forms;

use common\base\Model;

class ChangeEmailForm extends Model
{
	public $email;
	public $password;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['password', 'email'], 'trim'],
			[['password', 'email'], 'required'],
			[['password'], 'string', 'min' => 8],
			['email', 'email'],
		];
	}
	
	
	public function attributeLabels()
	{
		return [
			'password' => t('user/main', 'password'),
			'email' => t('user/main', 'email'),
		];
	}
	
}
