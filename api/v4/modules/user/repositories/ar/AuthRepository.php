<?php

namespace api\v4\modules\user\repositories\ar;

use api\v4\modules\user\entities\BalanceEntity;
use api\v4\modules\user\interfaces\repositories\AuthInterface;
use common\ddd\repositories\BaseRepository;
use Yii;

class AuthRepository extends BaseRepository implements AuthInterface {
	
	public function authentication($login, $password) {
		$user = $this->domain->getRepositories()->login->oneByLogin($login);
		if(empty($user)) {
			return false;
		}
		if(!Yii::$app->security->validatePassword($password, $user->password_hash)) {
			return false;
		}
		return $user;
	}
	
	public function updateBalance() {
	
	}
	
	public function getBalance() {
		$balance = [];
		return $this->domain->factory->entity->create('balance', $balance);
	}
	
	public function setToken($token) {
	
	}
	
}