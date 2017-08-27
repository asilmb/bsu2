<?php

namespace api\v4\modules\bank\services;

use common\ddd\data\Query;
use common\ddd\services\ActiveBaseService;
use Yii;

class BankService extends ActiveBaseService
{
	
	public function getBankList() {
		$query = new Query();
		$query->where('type_id','1');
		return Yii::$app->active->provider->all($query);
	}
	
	public function getBankInstruction($bank_id){
		$bankEntity =Yii::$app->active->provider->OneById($bank_id);
		return $bankEntity->description;
	}
}
