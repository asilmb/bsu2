<?php

namespace api\v4\modules\bank\services;


use api\v4\modules\bank\helpers\BankingHelper;
use common\ddd\services\ActiveBaseService;
use frontend\modules\account\dto\BankingDto;
use Yii;

class BankingService extends ActiveBaseService {
	
	
	public function auth(BankingDto $bankingDto) {
		$bankingDto->auth_id = uniqid();
		$bankingDto->method = 'auth-form';
		$bankingDto->method_content = [
			'field' => [
				'@id' => $bankingDto->form_body['id'],
				'@value' => $bankingDto->form_body['value'],
			],
		];
		BankingHelper::createRequest($bankingDto, true);
		$response = $this->repository->sendRequest($bankingDto);
		return $response['response']['@rid'];
	}
	
	public function getBankingData(BankingDto $bankingDto){
		
		//$bankingDto->auth_id = $this->auth($bankingDto);
		$bankingDto->auth_id = uniqid();
		
		$bankingDto->method = 'parse';
		$bankingDto->method_content = [
				'@type' => 'products',
		];
		BankingHelper::createRequest($bankingDto);
		$response = $this->repository->sendRequest($bankingDto);
		return $response;

	}
	public function listBankingProduct($query) {
		$query = $this->forgeQuery($query);
		$query->where('type_id', 3);
		return Yii::$app->active->provider->all($query);
	}
}
