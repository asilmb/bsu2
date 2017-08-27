<?php

namespace api\v4\modules\service\repositories\ar;

use common\ddd\repositories\ActiveArRepository;

class CategoryRepository extends ActiveArRepository {

	protected $modelClass = 'api\v4\modules\service\modelsDeco\Category';
	
	public function fieldAlias() {
		return [
			'name' => 'title',
			'title' => 'name',
		];
	}

}