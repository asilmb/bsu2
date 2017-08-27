<?php

namespace api\v4\modules\user\services;

use common\ddd\services\ActiveBaseService;

class TestService extends ActiveBaseService {

	public function getOneByRole($role) {
		$user = $this->repository->getOneByRole($role);
		return $user;
	}

	public function oneByLogin($login) {
		$user = $this->repository->oneByLogin($login);
		return $user;
	}

}
