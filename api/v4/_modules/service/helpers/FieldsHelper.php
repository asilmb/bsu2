<?php

namespace api\v4\modules\service\helpers;

use yii2lab\misc\yii\base\Model;
use api\v4\modules\service\modelsDeco\Service;
use api\v4\modules\service\modelsDeco\Favorite;
use yii\helpers\ArrayHelper;

class FieldsHelper extends Model {
	
	public static function findFields($model)
	{
		if($model->scenario == $model::SCENARIO_UPDATE) {
			$favorite = self::findFavorite($model->favorite_id);
			$fields = ArrayHelper::toArray($favorite)['fields'];
		} elseif($model->scenario == $model::SCENARIO_CREATE) {
			$service = self::findService($model->service_id);
			$fields = ArrayHelper::toArray($service)['fields'];
		}
		if(empty($fields)) {
			return [];
		}
		return ArrayHelper::index($fields, 'name');
	}
	
	protected static function findFavorite($favorite_id = null)
	{
		return Favorite::find()
			->where(['favorite_id' => $favorite_id])
			->one();
	}
	
	protected static function findService($service_id)
	{
		return Service::find()
			->where(['service_id' => $service_id])
			->with('field')
			->one();
	}
	
}
