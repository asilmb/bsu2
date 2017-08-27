<?php

namespace api\v4\modules\active\services;

use common\ddd\services\ActiveBaseService;

class HandlerService extends ActiveBaseService {
	
	public function getIdByPath($module, $controller, $action) {
		return $this->repository->getIdByPath($module, $controller, $action);
	}
	
}
