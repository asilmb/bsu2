<?php

namespace api\v4\modules\user\interfaces\services;

use yii2woop\tps\generated\enums\SubjectType;

interface LoginInterface {

	public function oneById($id);
	public function oneByLogin($login);
	public function create($login, $password, $email, $role = SubjectType::USER_UNIDENT);

}