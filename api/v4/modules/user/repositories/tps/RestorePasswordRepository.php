<?php

namespace api\v4\modules\user\repositories\tps;

use api\v4\modules\user\interfaces\repositories\RestorePasswordInterface;
use common\ddd\repositories\TpsRepository;

class RestorePasswordRepository extends TpsRepository implements RestorePasswordInterface {

	public function requestNewPassword($login) {
	
	}
	
	public function checkActivationCode($login, $code) {
	
	}
	
	public function setNewPassword($login, $code, $password) {
	
	}
	
	public function isExists($login) {
		return $this->domain->repositories->login->isExistsByLogin($login);
	}
}