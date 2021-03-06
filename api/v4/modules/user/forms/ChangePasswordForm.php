<?php

namespace api\v4\modules\user\forms;

use common\base\Model;

class ChangePasswordForm extends Model
{
	public $new_password;
	public $password;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['password', 'new_password'], 'trim'],
			[['password', 'new_password'], 'required'],
			[['password', 'new_password'], 'string', 'min' => 8],
			['new_password', 'compare', 'compareAttribute' => 'password', 'operator' => '!='],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'password' => t('user/main', 'password'),
			'new_password'=> t('user/security', 'new_password'),
		];
	}
	
}
