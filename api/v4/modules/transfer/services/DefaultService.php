<?php

namespace api\v4\modules\transfer\services;

use api\v4\modules\transfer\forms\DefaultForm;
use common\ddd\services\BaseService;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;

class DefaultService extends BaseService {
	
	public function walletToWallet($from, $to, $params = null) {
		$body = compact(['from','to']);
		$this->validateForm(DefaultForm::className(), $body, DefaultForm::SCENARIO_WALLET_WALLET);
		if (!$this->repository->isExistsWallet($to)){
			$error = new ErrorCollection();
			$error->add('to','transfer/default','wallet_not_exist');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	//public function walletToWallet($id, $params = []) {
	//
	//}
	//public function walletToWallet($id, $params = []) {
	//
	//}
	//public function walletToWallet($id, $params = []) {
	//
	//}
	//public function walletToWallet($id, $params = []) {
	//
	//}
	//public function getDataProvider($query = null) {
	//	return $this->repository->findAll($query)->getDataProvider();
	//}
	//
}
