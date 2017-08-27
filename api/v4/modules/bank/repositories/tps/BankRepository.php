<?php

namespace api\v4\modules\bank\repositories\tps;

use api\v4\modules\bank\entities\BankEntity;
use common\ddd\repositories\TpsRepository;
use common\ddd\data\Query;
use Yii;

use api\v4\modules\bank\models\Code;

class BankRepository extends TpsRepository {
	
	public function getBankByCardNumber($cardNumber) {
		/** todo: cache it shit */
		$bin = $this->getBinFromCardNumber($cardNumber);
		$data = $this->getBIKByBIN($bin);
		$bank = Code::findOne(['bik' => $data->provider->bik]);
		if(empty($bank)) {
			return null;
		}
		$entity = $this->forgeEntity($bank, BankEntity::className());
		return $entity;
	}
	
	private function getBIKByBIN($bin) {
		$query = new Query();
		$query->with('provider');
		$data = Yii::$app->bank->bin->oneById($bin, $query);
		return $data;
	}
	
	
	private function getBinFromCardNumber($cardNumber) {
		$pos = mb_strpos($cardNumber, '-');
		$bin = mb_substr($cardNumber, 0, $pos);
		$bin = intval($bin);
		return $bin;
	}

}