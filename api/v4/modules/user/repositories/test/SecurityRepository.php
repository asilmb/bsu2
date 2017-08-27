<?php

namespace api\v4\modules\user\repositories\test;

use common\ddd\repositories\BaseRepository;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;

class SecurityRepository extends BaseRepository {

	const PASSWORD = 'Wwwqqq111';

	public function changePassword($password, $newPassword) {
		if($password != self::PASSWORD) {
			$error = new ErrorCollection();
			$error->add('password', 'user/auth', 'incorrect_password');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	public function changeEmail($password, $email) {
		if($password != self::PASSWORD) {
			$error = new ErrorCollection();
			$error->add('password', 'user/auth', 'incorrect_password');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
}