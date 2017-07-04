<?php
namespace common\modules\user\forms;

use Yii;
use yii2lab\misc\yii\base\Model;

/**
 * Password reset request form
 */
class PasswordRequestResetForm extends Model
{
	public $email;

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
		$userClass = config('components.user.identityClass');
		return [
			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'exist',
				'targetClass' => $userClass::className(),
				'filter' => ['status' => $userClass::STATUS_ACTIVE],
				'message' => t('user/password', 'no_user_with_email'),
			],
		];
	}

	/**
	 * Sends an email with a link, for resetting the password.
	 *
	 * @return bool whether the email was send
	 */
	public function sendEmail()
	{
		$userClass = config('components.user.identityClass');
		/* @var $user User */
		$user = $userClass::findOne([
			'status' => $userClass::STATUS_ACTIVE,
			'email' => $this->email,
		]);

		if (!$user) {
			return false;
		}
		
		if (!$userClass::isPasswordResetTokenValid($user->password_reset_token)) {
			$user->generatePasswordResetToken();
			if (!$user->save()) {
				return false;
			}
		}

		return Yii::$app
			->mailer
			->compose(
				[
					'html' => '@common/modules/user/mail/password/resetToken-html',
					'text' => '@common/modules/user/mail/password/resetToken-text',
				],
				['user' => $user]
			)
			->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
			->setTo($this->email)
			->setSubject('Password reset for ' . Yii::$app->name)
			->send();
	}
}
