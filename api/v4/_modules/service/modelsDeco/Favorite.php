<?php

namespace api\v4\modules\service\modelsDeco;

use api\v4\modules\service\models\Favorite as BaseFavorite;
use yii\helpers\ArrayHelper;
use Yii;

class Favorite extends BaseFavorite {
	
	protected static $services = null;
	
	public function fields() {
		$billinginfo = ArrayHelper::toArray(json_decode($this->billinginfo));
		
		$service = static::$services[ $billinginfo['service_id'] ];
		$service = ArrayHelper::toArray($service);
		
		$fields['id'] = 'favorite_id';
		$fields['service_id'] = function () use ($service) {
			return intval($service['id']);
		};
		$fields['name'] = function () use ($service) {
			return $service['name'];
		};
		$fields['parent_id'] = function () use ($service) {
			return $service['parent_id'];
		};
		$fields['title'] = 'name';
		$fields['description'] = function () use ($service) {
			return $service['description'];
		};
		//$fields['billinginfo'] = ;
		$fields['picture'] = function () use ($service) {
			return $service['picture'];
		};
		$fields['picture_url'] = function () use ($service) {
			return $service['picture_url'];
		};
		$fields['synonyms'] = function () use ($service) {
			return $service['synonyms'];
		};
		$fields['fields'] = function () use ($service, $billinginfo) {
			if (empty($service['fields'])) {
				return null;
			}
			foreach ($service['fields'] as &$field) {
				if (array_key_exists($field['name'], $billinginfo['model'])) {
					$field['value'] = $billinginfo['model'][ $field['name'] ];
				}
			}
			return $service['fields'];
		};
		return $fields;
	}
	
	public function extraFields()
	{
		return [
			'billinginfo' => function () {
				$billinginfo = ArrayHelper::toArray(json_decode($this->billinginfo));
				return $billinginfo;
			},
		];
	}
	
	public static function find() {
		static::$services = static::findService();
		return parent::find()
			->orderBy(['position' => SORT_DESC]);
	}
	
	protected static function findService() {
		$all = parent::find()->andWhere(['user_id' => Yii::$app->user->id])->all();
		$serviceIds = [];
		foreach ($all as $row) {
			$billinginfo = json_decode($row->billinginfo);
			$serviceIds[] = intval($billinginfo->service_id);
		}
		$serviceIds = array_unique($serviceIds);
		$services = Service::find()->where(['service_id' => $serviceIds])->all();
		return ArrayHelper::index($services, 'service_id');
	}
	
}