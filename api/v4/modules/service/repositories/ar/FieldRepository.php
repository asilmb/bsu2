<?php

namespace api\v4\modules\service\repositories\ar;

use common\ddd\repositories\ActiveArRepository;
use yii\helpers\ArrayHelper;

class FieldRepository extends ActiveArRepository {

	protected $modelClass = 'api\v4\modules\service\models\Fields';

	// todo: переписать

	public function getAllByServiceId($serviceId) {
		$query = $this->forgeQuery(null);
		
		$query->with(['translate', 'validations', 'values']);
		$query->where('service_id', $serviceId);

		$all = $this->all($query);
		foreach($all as $item) {
			$result[] = $this->decodeItem($item);
		}
		return $this->forgeEntity($result);
	}
	
	public function fieldAlias() {
		return [
			'id' => 'service_param_id',
		];
	}
	
	private function decodeItem($item) {
		$item = ArrayHelper::toArray($item);
		if(!empty($item['validations'])) {
			$validations = [];
			foreach($item['validations'] as $k => $validation) {
				$validation['param'] = ArrayHelper::toArray(json_decode($validation['param']));
				$validations[] = $validation;
			}
			$item['validations'] = $validations;
		}
		return $item;
	}

}