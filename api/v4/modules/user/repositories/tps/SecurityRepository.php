<?php

namespace api\v4\modules\user\repositories\tps;

use common\ddd\repositories\TpsRepository;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;
use yii\web\UnauthorizedHttpException;
use yii2woop\tps\generated\exception\tps\BadCredentialsException;
use yii2woop\tps\generated\exception\tps\NotAuthenticatedException;
use yii2woop\tps\generated\exception\tps\PasswordChangeException;
use yii2woop\tps\generated\exception\tps\TooWeakPasswordException;
use yii2woop\tps\generated\transport\TpsCommands;

class SecurityRepository extends TpsRepository {
	
	public function changePassword($password, $newPassword) {
		
		$request = TpsCommands::passwordChangeByPreviousPassword($password, $newPassword);
		
		try {
			$request->send();
	
		} catch (NotAuthenticatedException $e) {
			throw new UnauthorizedHttpException();
		} catch (TooWeakPasswordException $e) {
			$error = new ErrorCollection();
			$error->add('new_password', 'user/auth', 'weak_password');
			throw new UnprocessableEntityHttpException($error);
		} catch (PasswordChangeException $e) {
			$error = new ErrorCollection();
			$error->add('password', 'user/auth', 'incorrect_password');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	public function changeEmail($password, $email) {
		$request = TpsCommands::updateEmail($password, $email);
		try {
			$request->send();
		} catch (NotAuthenticatedException $e) {
			throw new UnauthorizedHttpException();
		} catch (BadCredentialsException $e) {
			$error = new ErrorCollection();
			$error->add('password', 'user/auth', 'incorrect_password');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
}