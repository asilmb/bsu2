<?php

namespace api\v4\modules\user\repositories\test;

use api\v4\modules\user\interfaces\repositories\RegistrationInterface;
use common\ddd\repositories\BaseRepository;

class RegistrationRepository extends BaseRepository implements RegistrationInterface {

	public function generateActivationCode() {
		return 123456;
	}
	
	public function create($login, $password, $email) {
	
	}
	
	public function isExists($login) {
		return $this->domain->repositories->test->isExists(['login' => $login]);
	}
	
}