<?php

namespace api\v4\modules\user\repositories\tps;

use api\v4\modules\user\entities\BalanceEntity;
use api\v4\modules\user\helpers\LoginEntityFactory;
use api\v4\modules\user\interfaces\repositories\AuthInterface;
use common\ddd\repositories\TpsRepository;
use common\helpers\Registry;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii2woop\tps\components\TpsTransport;
use yii2woop\tps\generated\transport\TpsCommands;

class AuthRepository extends TpsRepository implements AuthInterface {
	
	private $sessionKey = 'balance';
	
	public function fieldAlias() {
		return [
			'id' => 'subject_id',
			'token' => 'authToken',
		];
	}
	
	public function authentication($login, $password) {
		try {
			$address = TpsTransport::getUserHostAddress();
			$request = TpsCommands::authentication($login, $password, $address);
			$user = $request->send();
			if($user) {
				return $this->forgeLoginEntity($user);
			}
		} catch (Exception $e) {}
		return false;
	}
	
	public function updateBalance() {
		Yii::$app->session[$this->sessionKey] = null;
		return $this->getBalance();
	}
	
	public function getBalance() {
		$balance = $this->_getBalance();
		return $this->domain->factory->entity->create('balance', $balance);
	}
	
	public function setToken($token) {
		if (Yii::$app->user->enableSession) {
			Yii::$app->session['token'] = $token;
		}
		Registry::set('secretKey', $token);
	}
	
	private function _getBalance() {
		$login = Yii::$app->user->identity->login;
		if(empty($login)) {
			return [];
		}
		if(empty(Yii::$app->session[$this->sessionKey])) {
			Yii::$app->session[$this->sessionKey] = $this->domain->login->getBalance($login);
		}
		return Yii::$app->session[$this->sessionKey];
	}
	
	protected function forgeLoginEntity($user, $class = null)
	{
		if(empty($user)) {
			return null;
		}
		$user = ArrayHelper::toArray($user);
		$user = $this->alias->decode($user);
		return LoginEntityFactory::forgeLoginEntity($user);
	}
}