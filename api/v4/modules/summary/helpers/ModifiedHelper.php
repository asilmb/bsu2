<?php

namespace api\v4\modules\summary\helpers;

use api\v4\modules\geo\models\City;
use api\v4\modules\geo\models\Country;
use api\v4\modules\geo\models\Region;
use api\v4\modules\service\models\Service;
use api\v4\modules\service\models\Category;
use api\v4\modules\summary\models\Resource;
use yii2lab\helpers\Helper;

class ModifiedHelper {
	
	public static function getList() {
		$dateList = [
			'city' => self::getLastDate(City::className()),
			'country' => self::getLastDate(Country::className()),
			'region' => self::getLastDate(Region::className()),
			//'summary_url' => self::getLastDateFromResource('type'),
			//'summary_id' => self::getLastDateFromResource('type'),
			'service' => self::getLastDate(Service::className(), 'modify_date'),
			'service_category' => self::getLastDate(Category::className(), 'modify_date'),
		];
		foreach($dateList as &$date) {
			$date = Helper::timeForApi($date);
		}
		return $dateList;
	}
	
	protected static function getLastDateFromResource($type, $field = 'date_change') {
		$lastItem = Resource::find()
			->where([$type => 'url'])
			->orderBy($field . ' DESC')
			->one();
		return $lastItem->$field;
	}
	
	protected static function getLastDate($modelClass, $field = 'date_change') {
		$lastItem = $modelClass::find()
			->orderBy($field . ' DESC')
			->one();
		if(is_object($lastItem)) {
			return $lastItem->$field;
		}
	}
	
}
