<?php

namespace api\v4\modules\user\repositories\test;

use api\v4\modules\user\interfaces\repositories\RestorePasswordInterface;
use common\ddd\repositories\BaseRepository;

class RestorePasswordRepository extends BaseRepository implements RestorePasswordInterface {

	public function requestNewPassword($login) {
	
	}
	
	public function checkActivationCode($login, $code) {
		if($code == 123456) {
			return true;
		}
		return false;
	}
	
	public function setNewPassword($login, $code, $password) {
	
	}
	
	public function isExists($login) {
		return $this->domain->repositories->test->isExists(['login' => $login]);
	}
	
}