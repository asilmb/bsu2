<?php

namespace api\v4\modules\user\services;

use api\v4\modules\user\helpers\LoginHelper;
use common\ddd\services\BaseService;
use Yii;
use api\v4\modules\user\forms\RegistrationForm;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;

class RegistrationService extends BaseService {
	
	public function createTempAccount($login, $email = null) {
		$body = compact(['login', 'email']);
		$this->validateForm(RegistrationForm::className(), $body, RegistrationForm::SCENARIO_REQUEST);
		$this->checkLoginExistsInTps($login);
		$activation_code = $this->repository->generateActivationCode();
		Yii::$app->account->temp->create($login, $email, $activation_code);
		$this->sendSmsWithActivationCode($login, $activation_code);
	}
	
	public function checkActivationCode($login, $activation_code) {
		$body = compact(['login', 'activation_code']);
		$this->validateForm(RegistrationForm::className(), $body, RegistrationForm::SCENARIO_CHECK);
		$this->checkLoginExistsInTemp($login);
		//$this->isActivated($login);
		$this->verifyActivationCode($login, $activation_code);
	}
	
	public function activateAccount($login, $activation_code) {
		$this->checkActivationCode($login, $activation_code);
		Yii::$app->account->temp->activate($login);
	}
	
	public function createTpsAccount($login, $activation_code, $password, $email = null) {
		$body = compact(['login', 'activation_code', 'password']);
		$this->validateForm(RegistrationForm::className(), $body, RegistrationForm::SCENARIO_CONFIRM);
		$this->checkLoginExistsInTemp($login);
		if(empty($email)) {
			$email = 'demo@wooppay.com';
		}
		$this->verifyActivationCode($login, $activation_code);
		$this->repository->create($login, $password, $email);
		Yii::$app->account->temp->delete($login);
	}

	protected function checkLoginExistsInTemp($login) {
		$isExists = $this->domain->repositories->temp->isExists($login);
		if(!$isExists) {
			$error = new ErrorCollection();
			$error->add('login', 'user/registration', 'temp_user_not_found');
			throw new UnprocessableEntityHttpException($error);
		}
	}

	protected function sendSmsWithActivationCode($login, $activation_code) {
		$loginParts = LoginHelper::splitLogin($login);
		$message = t('this/registration', 'activate_account_sms {activation_code}', ['activation_code' => $activation_code]);
		Yii::$app->notify->transport->sendSms($loginParts['phone'], $message);
	}

	protected function checkLoginExistsInTps($login) {
		$isExists = $this->repository->isExists($login);
		if($isExists) {
			$error = new ErrorCollection();
			$error->add('login', 'user/registration', 'user_already_exists_and_activated');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	protected function isActivated($login) {
		if(Yii::$app->account->temp->isActivated($login)) {
			$error = new ErrorCollection();
			$error->add('activation_code', 'user/registration', 'already_activated');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	protected function verifyActivationCode($login, $activation_code) {
		if(!Yii::$app->account->temp->checkActivationCode($login, $activation_code)) {
			$error = new ErrorCollection();
			$error->add('activation_code', 'user/registration', 'invalid_activation_code');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
}
