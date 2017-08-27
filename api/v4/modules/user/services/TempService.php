<?php

namespace api\v4\modules\user\services;

use api\v4\modules\user\entities\TempEntity;
use common\ddd\services\BaseService;
use Yii;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;

class TempService extends BaseService {
	
	public function isActivated($login) {
		$user = $this->oneByLogin($login);
		return $user->ip == Yii::$app->request->getUserIP();
	}
	
	public function checkActivationCode($login, $code) {
		$user = $this->oneByLogin($login);
		if(empty($user) || $user->activation_code != $code) {
			return false;
		}
		return $user;
	}
	
	public function activate($login) {
		$user = $this->oneByLogin($login);
		$user->ip = Yii::$app->request->getUserIP();
		$this->repository->update($user);
		return true;
	}
	
	public function create($login, $email, $code) {
		$isExists = $this->repository->isExists($login);
		if($isExists) {
			$error = new ErrorCollection();
			$error->add('login', 'user/registration', 'user_already_exists_but_not_activation');
			throw new UnprocessableEntityHttpException($error);
		}
		$entity = new TempEntity;
		$entity->login = $login;
		$entity->email = $email;
		$entity->activation_code = $code;
		return $this->repository->insert($entity);
	}

	public function delete($login) {
		$user = $this->oneByLogin($login);
		return $this->repository->delete($user);
	}
	
	private function isExpire($create_time) {
		$left = TIMESTAMP - $create_time;
		$paramExpire = param('user.registration.tempLoginExpire');
		return $left > $paramExpire;
	}
	
	private function oneByLogin($login) {
		$user = $this->repository->oneByLogin($login);
		if(empty($user)) {
			return null;
			//throw new NotFoundHttpException();
		}
		$create_time = strtotime($user->create_time);
		if($this->isExpire($create_time)) {
			$this->repository->delete($user);
			return null;
		}
		return $user;
	}
	
}
