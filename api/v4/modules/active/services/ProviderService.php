<?php

namespace api\v4\modules\active\services;

use common\ddd\services\ActiveBaseService;
use Yii;

class ProviderService extends ActiveBaseService {
	
	public function getProvidersByType($type_id, $query) {
		$query = $this->forgeQuery($query);
		$query->where('type_id', $type_id);
		return Yii::$app->active->provider->all($query);
	}
	
}
