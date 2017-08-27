<?php

namespace api\v4\modules\user\services;

use api\v4\modules\user\forms\RestorePasswordForm;
use common\ddd\helpers\ErrorCollection;
use common\ddd\services\BaseService;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;

class RestorePasswordService extends BaseService {
	
	public function request($login) {
		$body = compact(['login']);
		$this->validateForm(RestorePasswordForm::className(), $body, RestorePasswordForm::SCENARIO_REQUEST);
		$this->validateLogin($login);
		$this->repository->requestNewPassword($login);
	}
	
	public function checkActivationCode($login, $activation_code) {
		$body = compact(['login', 'activation_code']);
		$this->validateForm(RestorePasswordForm::className(), $body, RestorePasswordForm::SCENARIO_CHECK);
		$this->validateLogin($login);
		$this->verifyActivationCode($login, $activation_code);
		
	}
	
	public function confirm($login, $activation_code, $password) {
		$body = compact(['login', 'activation_code', 'password']);
		$this->validateForm(RestorePasswordForm::className(), $body, RestorePasswordForm::SCENARIO_CONFIRM);
		$this->validateLogin($login);
		$this->verifyActivationCode($login, $activation_code);
		$this->repository->setNewPassword($login, $activation_code, $password);
	}
	
	protected function validateLogin($login) {
		$user = $this->repository->isExists($login);
		if(empty($user)) {
			$error = new ErrorCollection();
			$error->add('login', 'user/main', 'login_not_found');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	protected function verifyActivationCode($login, $activation_code) {
		$isChecked = $this->repository->checkActivationCode($login, $activation_code);
		if(!$isChecked) {
			$error = new ErrorCollection();
			$error->add('activation_code', 'user/password', 'invalid_activation_code');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
}
