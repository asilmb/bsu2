<?php

namespace api\v4\modules\user\helpers;

use Yii;
use Exception;
use yii\base\Model;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\exception\tps\UserAlreadyRegisteredException;
use yii2woop\tps\generated\enums\SubjectType;

class TpsUserHelper extends Model {
	
	public function isExists($login) {
		if (YII_ENV_TEST) {
			return false;
		}
		try {
			$request = TpsCommands::searchSubject([$login]);
			$data = $request->send();
		} catch (Exception $e) {}
		if (!empty($data['values'])) {
			$this->addError('login', t('this/registration', 'user_already_exists'));
			return true;
		}
		return false;
	}
	
	public function insert($login, $password, $email = null) {
		if (YII_ENV_TEST) {
			return true;
		}
		$insertSubjectResult = false;
		try {
			$email = !empty($email) ? $email : 'api@wooppay.com';
			$request = TpsCommands::insertSubject($login, Yii::$app->request->getUserIP(), $password, SubjectType::USER_UNIDENT, $email, '');
			$request->send();
			$insertSubjectResult = true;
		} catch (UserAlreadyRegisteredException $e) {
			$this->addError('login', t('this/registration', 'user_already_exists'));
		} catch (Exception $e) {
			$this->addError('login', t('this/registration', 'user_dont_create_by_unknown_reason'));
		}
		return $insertSubjectResult;
	}
	
}
