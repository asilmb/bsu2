<?php

namespace api\v4\modules\service\repositories\ar;

use api\v4\modules\service\entities\FavoriteDecoEntity;
use common\ddd\data\Query;
use common\ddd\repositories\ActiveArRepository;
use Yii;
use yii\helpers\ArrayHelper;

class FavoriteRepository extends ActiveArRepository {

	public function fieldAlias() {
		return [
			'id' => 'favorite_id',
		];
	}
	
	public function oneById($id, Query $query = null) {
		$model = $this->oneModelByCondition(['id' => $id]);
		$favoriteItem = ArrayHelper::toArray($model);
		$favoriteArray = $this->fields([$favoriteItem]);
		$favoriteItem = $favoriteArray[0];
		$entity = $this->forgeEntity($favoriteItem, FavoriteDecoEntity::className());
		return $entity;
	}
	
	public function all(Query $query = null) {
		$model = $this->allModelsByCondition();
		$favoriteArray = ArrayHelper::toArray($model);
		$favoriteArray = $this->fields($favoriteArray);
		return $this->forgeEntity($favoriteArray, FavoriteDecoEntity::className());
	}
	
	private function fields($favoriteArray) {
		$favoriteArrayDecoded = $this->alias->decode($favoriteArray);
		$serviceIdList = $this->extractServiceIdList($favoriteArrayDecoded);
		$serviceArrayList = $this->getServiceIndexedList($serviceIdList);
		$result = [];
		foreach ($favoriteArrayDecoded as &$favoriteItem) {
			$serviceId = intval($favoriteItem['billinginfo']['service_id']);
			$result[] = $this->field($favoriteItem, $serviceArrayList[$serviceId]);
		}
		return $result;
	}
	
	private function field($favoriteArray, $serviceArray) {
		$serviceArray['service_id'] = intval($serviceArray['id']);
		$serviceArray['id'] = intval($favoriteArray['id']);
		$value = $favoriteArray['billinginfo']['model'];
		$serviceArray['fields'] = $this->assignFieldsValue($serviceArray['fields'], $value);
		return $serviceArray;
	}
	
	private function assignFieldsValue($fields, $value) {
		if(empty($fields) || empty($value)) {
			return $fields;
		}
		foreach ($fields as &$field) {
			$fieldName = $field['name'];
			$field['value'] = $value[$fieldName];
		}
		return $fields;
	}
	
	private function extractServiceIdList($favoriteArray) {
		if(empty($favoriteArray)) {
			return [];
		}
		$result = [];
		foreach($favoriteArray as $item) {
			$result[] = intval($item['billinginfo']['service_id']);
		}
		$result = array_unique($result);
		$result = array_values($result);
		return $result;
	}
	
	private function getServiceIndexedList($serviceId) {
		$query = $this->forgeQuery(null);
		$query->where('id', $serviceId);
		$entityList = Yii::$app->service->service->all($query);
		$arrayList = ArrayHelper::toArray($entityList);
		$arrayListIndexed = ArrayHelper::index($arrayList, 'id');
		return $arrayListIndexed;
	}
	
}