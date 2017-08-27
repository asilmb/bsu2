<?php

namespace api\v4\modules\user\services;

use api\v4\modules\user\forms\LoginForm;
use api\v4\modules\user\interfaces\services\AuthInterface;
use common\ddd\helpers\ErrorCollection;
use common\ddd\services\BaseService;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class AuthService extends BaseService implements AuthInterface {
	
	public function authentication($login, $password) {
		$body = compact(['login', 'password']);
		$body = $this->validateForm(LoginForm::className(), $body);
		$user = $this->repository->authentication($body['login'], $body['password']);
		if (empty($user)) {
			$error = new ErrorCollection();
			$error->add('password', 'user/auth', 'incorrect_login_or_password');
			throw new UnprocessableEntityHttpException($error);
		}
		$this->repository->setToken($user->token);
		$user->showToken();
		return $user;
	}
	
	public function authenticationFromWeb($login, $password, $rememberMe = false) {
		$user = $this->authentication($login, $password);
		if (empty($user)) {
			return null;
		}
		$duration = $rememberMe ? param('user.auth.rememberExpire') : 0;
		Yii::$app->user->login($user, $duration);
	}
	
	public function authenticationByToken($token, $type = null) {
		$this->repository->setToken($token);
		$user = $this->domain->repositories->login->oneByToken($token, $type);
		return $user;
	}
	
	public function logout() {
		Yii::$app->user->logout();
	}
	
	public function denyAccess() {
		if (Yii::$app->user->getIsGuest()) {
			Yii::$app->user->loginRequired();
		} else {
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}
	}
	
	public function breakSession() {
		if (APP == API) {
			throw  new UnauthorizedHttpException;
		} else {
			$this->logout();
			Yii::$app->user->loginRequired();
		}
	}
	
	public function getIdentity() {
		$identity = Yii::$app->user->identity;
		if(empty($identity)) {
			throw new UnauthorizedHttpException();
		}
		return $identity;
	}
	
	public function getBalance() {
		return $this->domain->repositories->auth->getBalance();
	}
	
	public function updateBalance() {
		return $this->repository->updateBalance();
	}
	
}
