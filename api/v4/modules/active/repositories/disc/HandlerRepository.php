<?php

namespace api\v4\modules\active\repositories\disc;

use common\ddd\repositories\ActiveDiscRepository;

class HandlerRepository extends ActiveDiscRepository {

	public $table = 'active_handler';

	public function getIdByPath($module, $controller, $action) {
		$query = $this->forgeQuery(null);
		$query->where('module', $module);
		$query->where('controller', $controller);
		$query->where('action', $action);
		$entity = $this->one($query);
		return $entity->id;
	}

}
