<?php
namespace common\modules\user\forms;

use Yii;
use yii2lab\misc\yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
	public $login;
	public $password;
	public $rememberMe = true;

	private $_user;

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
			// login and password are both required
			[['login', 'password'], 'required'],
			// rememberMe must be a boolean value
			['rememberMe', 'boolean'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
		];
	}

	/**
	 * Logs in a user using the provided login and password.
	 *
	 * @return bool whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			$user = $this->getUser();
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
			return Yii::$app->user->login($user, $duration);
		} else {
			return false;
		}
	}

	/**
	 * Finds user by [[login]]
	 *
	 * @return \yii\web\IdentityInterface|null
	 */
	protected function getUser()
	{
		if ($this->_user === null) {
			$identityClass = config('components.user.identityClass');
			$this->_user = $identityClass::authentication($this->login, $this->password);
		}
		return $this->_user;
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user) {
				$this->addError($attribute, t('user/auth', 'incorrect_login_or_password'));
			}
		}
	}

}
