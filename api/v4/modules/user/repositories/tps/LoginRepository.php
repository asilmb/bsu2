<?php

namespace api\v4\modules\user\repositories\tps;

use api\v4\modules\user\helpers\LoginEntityFactory;
use api\v4\modules\user\interfaces\repositories\LoginInterface;
use common\ddd\repositories\TpsRepository;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;
use yii2woop\tps\components\RBAC;
use yii2woop\tps\components\RBACRoles;
use yii2woop\tps\generated\exception\tps\NotAuthenticatedException;
use yii2woop\tps\generated\transport\TpsCommands;

class LoginRepository extends TpsRepository implements LoginInterface {
	
	public function fieldAlias() {
		return [
			'id' => 'subject_id',
			'token' => 'authToken',
		];
	}
	
	public function isExistsByLogin($login) {
		return $this->oneByLogin($login);
	}
	
	public function oneByLogin($login) {
		$userList = $this->allByLogin($login);
		if(empty($userList)) {
			return null;
		}
		$user = $userList[0];
		return $this->forgeEntity($user);
	}

	public function oneById($id) {
		$userList = $this->allById($id);
		if(empty($userList)) {
			return null;
		}
		$user = $userList[0];
		return $this->forgeEntity($user);
	}
	
	public function oneByToken($token, $type = null) {
		try {
			$request = TpsCommands::getCurrentSubjectData();
			$user = $request->send();
			if($user) {
				return $this->forgeEntity($user);
			}
		} catch (Exception $e) {}
		return false;
	}
	
	public function getBalance($login) {
		try {
			$balanceData = TpsCommands::getSubjectBalance($login)->send();
		} catch(NotAuthenticatedException $e) {
			//throw new UnauthorizedHttpException();
			$balanceData = [];
		}
		$balance = $this->domain->factory->entity->create('balance', $balanceData);
		return $balance;
	}
	
	public function create($login, $password, $email, $role, $parent = '') {
		$request = TpsCommands::insertSubject($login, Yii::$app->request->getUserIP(), $password, $role, $email, $parent);
		$request->send();
	}
	
	protected function allByLogin($login) {
		$login = ArrayHelper::toArray($login);
		try {
			$request = TpsCommands::searchSubject(null, $login);
			$data = $request->send();
			return $this->forgeUserListFromTpsResponse($data);
		} catch (Exception $e) {}
		return [];
	}
	
	protected function allById($ids) {
		$ids = ArrayHelper::toArray($ids);
		try {
			$request = TpsCommands::searchSubject($ids);
			$data = $request->send();
			return $this->forgeUserListFromTpsResponse($data);
		} catch (Exception $e) {}
		return [];
	}
	
	protected function forgeUserListFromTpsResponse($data)
	{
		if(!empty($data['values'])) {
			$userList = [];
			foreach($data['values'] as $user) {
				$user = array_combine($data['keys'], $user);
				$userList[] = $user;
			}
			return $userList;
		}
		return [];
	}
	
	public function forgeEntity($user, $class = null)
	{
		if(empty($user)) {
			return null;
		}
		$user = ArrayHelper::toArray($user);
		$user = $this->alias->decode($user);
		return LoginEntityFactory::forgeLoginEntity($user);
	}
}