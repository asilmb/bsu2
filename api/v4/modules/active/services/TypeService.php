<?php

namespace api\v4\modules\active\services;

use common\ddd\data\Query;
use common\ddd\services\ActiveBaseService;
use Yii;

class TypeService extends ActiveBaseService {
	
	// todo: make unique [title]
	
	public $foreignServices = [
		'active.type' => [
			'field' => 'parent_id',
			'notFoundMessage' => ['active/type', 'not_found'],
		],
	];
	
	public function oneByIdWithFields($id, Query $query = null) {
		$query = $this->forgeQuery($query);
		$query->with('fields');
		return $this->oneById($id, $query);
	}
}
