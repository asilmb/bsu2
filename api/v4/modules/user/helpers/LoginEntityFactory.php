<?php

namespace api\v4\modules\user\helpers;

use api\v4\modules\user\entities\LoginEntity;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class LoginEntityFactory {
	
	public static function forgeLoginEntity($user)
	{
		if(empty($user)) {
			return null;
		}
		$user = ArrayHelper::toArray($user);
		$user['profile'] = self::attachProfile($user['login']);
		return self::forgeEntity($user);
	}
	
	protected static function attachProfile($login)
	{
		try {
			$result = Yii::$app->account->repositories->profile->oneById($login);
		} catch (NotFoundHttpException $e) {
			$result = null;
		}
		return $result;
	}
	
	protected static function forgeEntity($data) {
		if(empty($data)) {
			return [];
		}
		if(!ArrayHelper::isIndexed($data)) {
			return Yii::$app->account->factory->entity->create('login', $data);
		}
		$result = [];
		foreach($data as $item) {
			$result[] = self::forgeEntity($item);
		}
		return $result;
	}
	
}