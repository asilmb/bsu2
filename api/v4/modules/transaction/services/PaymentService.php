<?php

namespace api\v4\modules\transaction\services;

use api\v4\modules\transaction\forms\CommissionForm;
use api\v4\modules\transaction\forms\PaymentForm;
use api\v4\modules\transaction\forms\ApiPaymentRequest;
use common\ddd\services\BaseService;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2woop\tps\generated\exception\tps\NoCommissionException;

class PaymentService extends BaseService
{
	
	public function check($body)
	{
		$this->validatePay($body,ApiPaymentRequest::SCENARIO_API_CHECK);
		
		return $this->repository->check($body);
	}
	
	
	//Оплата с кошелька
	public function pay($body) {
		$this->validatePay($body);
		return $this->repository->pay($body);
	}
	
	public function payFromCard($body) {
		$cardId = ArrayHelper::getValue($body, 'card_id');
		$this->validateCard($cardId);
		//$body = $this->validatePay($body);
		return $this->repository->payFromCard($body);
	}
	
	//Подтверждение оплаты с привязанной карты
	public function confirm($body) {
		return $this->repository->confirm($body['operationId']);
	}
	
	public function getCommissionByServiceId($serviceId, $amount) {
		return $this->commission([
			'service_id' => $serviceId,
			'amount' => $amount,
		]);
	}
	
	public function commission($body) {
		$this->validateForm(CommissionForm::className(), $body);
		$this->validateService($body['service_id']);
		try {
			$result['amount'] = $this->repository->getCommissionByService($body['service_id'], $body['amount']);
		} catch (NoCommissionException $e) {
			$error = new ErrorCollection();
			$error->add('amount', 'transaction/payment', 'big_amount');
			throw new UnprocessableEntityHttpException($error);
		}
		return $result;
	}
	
	public function debt($body) {
		$this->validatePay($body);
		return $this->repository->debt($body);
	}
	
	private function validatePay($body,$scenario = null) {
		
		//$this->validateForm(ApiPaymentRequest::className(), $body,$scenario);
		$this->validateService($body['service_id']);
		$body['fields'] = Yii::$app->service->field->validate($body['service_id'], $body['fields']);
		
		return $body;
	}
	
	private function validateService($serviceId) {
		try {
			$service = Yii::$app->service->service->oneById($serviceId);
		} catch (NotFoundHttpException $e) {
			$error = new ErrorCollection();
			$error->add('service_id', 'service/service', 'not_found');
			throw new UnprocessableEntityHttpException($error);
		}
		return $service;
	}
	
	private function validateCard($cardId) {
		if(empty($cardId)) {
			return;
		}
		if(!is_numeric($cardId)) {
			$error = new ErrorCollection();
			$error->add('card_id', 'yii', '{attribute} must be an integer.', ['attribute' => 'card_id']);
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
}
