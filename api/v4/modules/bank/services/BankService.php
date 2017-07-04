<?php

namespace api\v4\modules\bank\services;

use yii2woop\tps\generated\transport\TpsCommands;
use api\v4\modules\bank\models\Code;

class BankService
{
	
	public function getBankByCardNumber($cardNumber) {
		/** todo: cache it shit */
		$bin = $this->getBinFromCardNumber($cardNumber);
		$data = $this->getBIKByBIN($bin);
		$bank = Code::findOne(['bik' => $data['bik']]);
		if(empty($bank)) {
			return null;
		}
		return $bank;
	}
	
	private function getBIKByBIN($bin) {
		$request = TpsCommands::getBIKByBIN($bin);
		$data = $request->send();
		return $data;
	}
	
	private function getBinFromCardNumber($cardNumber) {
		$pos = mb_strpos($cardNumber, '-');
		$bin = mb_substr($cardNumber, 0, $pos);
		$bin = intval($bin);
		return $bin;
	}
	
}
