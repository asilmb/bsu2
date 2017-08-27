<?php

namespace api\v4\modules\user\services;

use Yii;

use common\ddd\services\ActiveBaseService;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProfileService extends ActiveBaseService {
	
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
		$body = ArrayHelper::toArray($body);
		unset($body['avatar']);
		$this->updateById($profile->login, $body);
	}
	
}
