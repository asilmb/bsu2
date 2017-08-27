<?php

namespace api\v4\modules\user\repositories\disc;

use common\ddd\repositories\ActiveDiscRepository;

class TestRepository extends ActiveDiscRepository {

	protected $table = 'user';

	public function getOneByRole($role) {
		return $this->findOne([
			'role' => $role,
		]);
	}

	public function oneByLogin($login) {
		return $this->findOne([
			'login' => $login,
		]);
	}

}