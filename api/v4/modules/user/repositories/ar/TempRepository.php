<?php

namespace api\v4\modules\user\repositories\ar;

use common\ddd\repositories\ActiveArRepository;

class TempRepository extends ActiveArRepository {
	
	protected $modelClass = 'api\v4\modules\user\models\UserRegistration';
	protected $primaryKey = 'login';
	
	public function oneByLogin($login) {
		$model = $this->oneModelByCondition(['login' => $login]);
		return $this->forgeEntity($model);
	}
	
}