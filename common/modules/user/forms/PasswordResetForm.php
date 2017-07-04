<?php
namespace common\modules\user\forms;

use yii2lab\misc\yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Password reset form
 */
class PasswordResetForm extends Model
{
	public $password;

	/**
	 * @var \yii2lab\user\models\identity\Db
	 */
	private $_user;

	/**
	 * @inheritdoc
	 */
	public function modelClass()
	{
		return config('components.user.identityClass');
	}

	/**
	 * Creates a form model given a token.
	 *
	 * @param string $token
	 * @param array $config name-value pairs that will be used to initialize the object properties
	 * @throws \yii\base\InvalidParamException if token is empty or not valid
	 */
	public function __construct($token, $config = [])
	{
		if (empty($token) || !is_string($token)) {
			throw new InvalidParamException('Password reset token cannot be blank.');
		}
		$userClass = config('components.user.identityClass');
		$this->_user = $userClass::findByPasswordResetToken($token);
		if (!$this->_user) {
			throw new InvalidParamException('Wrong password reset token.');
		}
		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['password', 'required'],
			['password', 'string', 'min' => 6],
		];
	}

	/**
	 * Resets password.
	 *
	 * @return bool if password was reset.
	 */
	public function resetPassword()
	{
		$user = $this->_user;
		$user->setPassword($this->password);
		$user->removePasswordResetToken();

		return $user->save(false);
	}
}
