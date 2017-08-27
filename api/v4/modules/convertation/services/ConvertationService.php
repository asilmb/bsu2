<?php

namespace api\v4\modules\convertation\services;

use common\ddd\services\BaseService;
use yii\web\NotFoundHttpException;
use common\ddd\data\Query;


class ConvertationService extends BaseService {
	
	public function accountToAccount($body) {
		return $this->repository->accountToAccount($body);
	}
	
	public function cardToAccount($body) {
		return $this->repository->cardToAccount($body);
	}

	public  function accountToCard($body){
		return $this->repository->accountToCard($body);
	}

}
