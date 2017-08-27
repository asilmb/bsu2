<?php
/**
 * WebUser
 */
namespace api\v4\modules\user\web;

use common\helpers\Registry;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\web\IdentityInterface;

/**
 * @property-read User $model
 */
class User extends \yii\web\User
{
	/** @var User */
	private $_model;

	public function init()
	{
		//parent::init();

		/*if ($this->identityClass === null) {
			throw new InvalidConfigException('User::identityClass must be set.');
		}*/
		if ($this->enableAutoLogin && !isset($this->identityCookie['name'])) {
			throw new InvalidConfigException('User::identityCookie must contain the "name" element.');
		}
	}

	public function loginByAccessToken($token, $type = null)
	{
		$identity = Yii::$app->account->auth->authenticationByToken($token, $type);
		if ($identity && $this->login($identity)) {
			return $identity;
		} else {
			return null;
		}
	}

	protected function getIdentityAndDurationFromCookie()
	{
		$value = Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
		if ($value === null) {
			return null;
		}
		$data = json_decode($value, true);
		if (count($data) == 3) {
			list ($id, $authKey, $duration) = $data;
			$identity = Yii::$app->account->login->oneById($id);
			if ($identity !== null) {
				if (!$identity instanceof IdentityInterface) {
					throw new InvalidValueException("Class::findIdentity() must return an object implementing IdentityInterface.");
				} elseif (!$identity->validateAuthKey($authKey)) {
					Yii::warning("Invalid auth key attempted for user '$id': $authKey", __METHOD__);
				} else {
					return ['identity' => $identity, 'duration' => $duration];
				}
			}
		}
		$this->removeIdentityCookie();
		return null;
	}

	protected function renewAuthStatus()
	{
		$session = Yii::$app->getSession();
		$id = $session->getHasSessionId() || $session->getIsActive() ? $session->get($this->idParam) : null;

		if ($id === null) {
			$identity = null;
		} else {
			$identity = Yii::$app->account->login->oneById($id);
			Registry::set('secretKey', Yii::$app->session['token']);
		}

		$this->setIdentity($identity);

		if ($identity !== null && ($this->authTimeout !== null || $this->absoluteAuthTimeout !== null)) {
			$expire = $this->authTimeout !== null ? $session->get($this->authTimeoutParam) : null;
			$expireAbsolute = $this->absoluteAuthTimeout !== null ? $session->get($this->absoluteAuthTimeoutParam) : null;
			if ($expire !== null && $expire < time() || $expireAbsolute !== null && $expireAbsolute < time()) {
				$this->logout(false);
			} elseif ($this->authTimeout !== null) {
				$session->set($this->authTimeoutParam, time() + $this->authTimeout);
			}
		}

		if ($this->enableAutoLogin) {
			if ($this->getIsGuest()) {
				$this->loginByCookie();
			} elseif ($this->autoRenewCookie) {
				$this->renewIdentityCookie();
			}
		}
	}

}