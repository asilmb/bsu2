<?php

namespace common\modules\user\forms;

use yii2lab\misc\yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $email;
	public $username;
	public $password;

	/**
	 * @inheritdoc
	 */
	public function modelClass()
	{
		return config('components.user.identityClass');
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['email', 'username', 'password'], 'trim'],
			[['email', 'username', 'password'], 'required'],
			['email', 'email'],
			[['email', 'username'], 'string', 'max' => 255],
			['password', 'string', 'min' => 6],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup()
	{
		if (!$this->validate()) {
			return null;
		}

		/** @var User $user */
		$user = $this->loadModel();
		$user->generateAuthKey();
		$user->setPassword($this->password);

		return $this->saveModel();
	}
}
