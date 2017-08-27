<?php

namespace api\v4\modules\user\services;

use api\v4\modules\user\interfaces\services\LoginInterface;

use common\ddd\helpers\ErrorCollection;
use common\ddd\services\BaseService;
use common\exceptions\UnprocessableEntityHttpException;
use Exception;
use yii2woop\tps\components\RBAC;
use yii2woop\tps\components\RBACRoles;
use yii2woop\tps\generated\enums\SubjectType;

class LoginService extends BaseService implements LoginInterface {

	public function oneById($id) {
		$id = intval($id);
		$user = $this->repository->oneById($id);
		return $user;
	}

	public function oneByLogin($login) {
		$user = $this->repository->oneByLogin($login);
		return $user;
	}

	public function create($login, $password, $email, $role = SubjectType::USER_UNIDENT) {
		$user = $this->repository->oneByLogin($login);
		if (!empty($user)) {
			$error = new ErrorCollection();
			$error->add('login', 'user/registration', 'user_already_exists_and_activated');
			throw new UnprocessableEntityHttpException($error);
		}
		try {
			$email = !empty($email) ? $email : 'api@wooppay.com';
			$this->repository->create($login, $password, $email, $role);
		} catch (Exception $e) {
			$error = new ErrorCollection();
			$error->add('login', 'this/registration', 'user_dont_create_by_unknown_reason');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	public function getBalance($login) {
		$balance = $this->repository->getBalance($login);
		$isSimpleUser = RBAC::checkAccess(RBACRoles::UNKNOWN_USER) || RBAC::checkAccess(RBACRoles::USER);
		if ($isSimpleUser && $balance->active < 0) {
			$balance->active = 0;
		}
		return $balance;
	}
}
