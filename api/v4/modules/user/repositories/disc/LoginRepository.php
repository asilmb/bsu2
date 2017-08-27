<?php

namespace api\v4\modules\user\repositories\disc;

use api\v4\modules\user\helpers\LoginEntityFactory;
use api\v4\modules\user\interfaces\repositories\LoginInterface;
use common\ddd\repositories\ActiveDiscRepository;
use yii\helpers\ArrayHelper;

class LoginRepository extends ActiveDiscRepository implements LoginInterface {

	protected $table = 'user';
	
	public function fieldAlias() {
		return [
			'name' => 'username',
			'token' => 'auth_key',
			'creation_date' => 'created_at',
		];
	}
	
	public function isExistsByLogin($login) {
		return $this->isExists(['login' => $login]);
	}
	
	public function oneByLogin($login) {
		$model = $this->oneModelByCondition(['login' => $login]);
		return $this->forgeEntity($model);
	}

	public function oneByToken($token, $type = null) {
		$model = $this->oneModelByCondition(['token' => $token]);
		return $this->forgeEntity($model);
	}
	
	public function forgeEntity($user, $class = null)
	{
		if(empty($user)) {
			return null;
		}
		$user = ArrayHelper::toArray($user);
		$user['roles'] = explode(',', $user['role']);
		$user = $this->alias->decode($user);
		return LoginEntityFactory::forgeLoginEntity($user);
	}
	
	public function getBalance($login) {
		return [];
	}
}