<?php

namespace api\v4\modules\notify\repositories\ar;

use common\ddd\repositories\ActiveArRepository;

class TransportRepository extends ActiveArRepository {

	public function deleteAll() {
		$modelClass = $this->modelClass;
		$modelClass::deleteAll();
	}

}