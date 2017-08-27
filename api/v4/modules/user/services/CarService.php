<?php

namespace api\v4\modules\user\services;

use Yii;

use common\ddd\services\ActiveBaseService;
use yii\web\NotFoundHttpException;

class CarService extends ActiveBaseService {
	
	public function getSelf() {
		$login = Yii::$app->user->identity->login;
		try {
			$profile = $this->oneById($login);
		} catch (NotFoundHttpException $e) {
			$this->create(['login' => $login]);
			$profile = $this->oneById($login);
		}
		return $profile;
	}
	
	public function updateSelf($body) {
		$profile = $this->getSelf();
		$this->updateById($profile->login, $body);
	}
	
}
