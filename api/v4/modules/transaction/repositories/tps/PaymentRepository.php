<?php

namespace api\v4\modules\transaction\repositories\tps;


use api\v4\modules\service\models\ServiceDAO;
use api\v4\modules\transaction\entities\DebtEntity;
use api\v4\modules\transaction\entities\PaymentCheckEntity;
use api\v4\modules\transaction\helpers\BlackHole;
use api\v4\modules\transaction\helpers\CardServices;
use api\v4\modules\transaction\helpers\ServicesType;
use common\ddd\helpers\ErrorCollection;
use common\ddd\repositories\TpsRepository;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii2lab\store\drivers\Json;
use yii2woop\tps\generated\enums\OperationSubType;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\transport\TpsOperations;
use api\v4\modules\transaction\forms\ApiPaymentRequest;


class PaymentRepository extends TpsRepository {
	
	
	public function check($body) {
		
	}
	
	//Оплата с кошелька
	public function pay($body)
	{
		$check['commission'] = [];
		$card = new CardServices();
		//Получаем сервис по id
		$service = Yii::$app->service->service->oneById($body['service_id']);
		$body['fields']['button'] = true;
		
		
		//Получаем id транзакции которая необходима для оплаты
		$check = TpsCommands::merchantCheck($service->merchant,$service->name,intval($body['service_id']),(object)$body['fields'])->send();
		//$check['commission'] = $card::getCommissionBySpec($body['service_id'], $body['fields']['amount'], $card::SUBJECT_RESMI);
		
		
		$check['amount'] = isset($body['bodyAmount']) ? $body['bodyAmount'] : $body['fields']['amount'];
	
		//Обязательное условие передача информации имя сервиса,id, поле которое содержит в себе то что пришло
		$billingInfo = json_encode(array('serviceName'=>$service->name,'service_id'=>$body['service_id'],'fields' => $check));
		
		//Оплата с кошелька возвращается $operationId
		$operationId = TpsOperations::newPayment(OperationSubType::SIMPLE, $service->merchant, floatval($body['fields']['amount']),$billingInfo,intval($body['service_id']),$body['fields']['account'])->send();
		
		
		$card->updateNewPaymentsCount();
		//Обязательное условие передача информации $operationId
		$additionalBillingInfo = array('txn_id' => (string)$operationId);
		$additionalBillingInfo = json_encode($additionalBillingInfo);
		
		try {
			$res = Yii::$app->transaction->history->findOne($operationId);
		} catch (NotFoundHttpException $e) {
			throw new ServerErrorHttpException(t('transaction/payment', 'operation_not_found'));
		}
		
		//Подтверждение заказа
		$confirmOperation = TpsOperations::confirm($operationId, $authCode=null, $additionalBillingInfo)->send();
		
		return $operationId;
	}
	
	
	
	//Получение задолженности происходит только по сложным услугам
	public function debt($body)
	{
		//Получаем сервис по id
		$service = Yii::$app->service->service->oneById($body['service_id']);
		
		//Для сложных услуг необходима кнопка true
		$body['fields']['button'] =  true;
		//$body['fields']['amount'] = array("7"=>"500","8"=>"200");
		//$body['fields']['invoiceId'] = "170710275503";
		
		//Получаем id транзакции которая необходима для оплаты
		$response = TpsCommands::merchantCheck($service->merchant,$service->name,intval($body['service_id']),(object)$body['fields'])->send();
		$response['amount'] = intval($response['amount']);
		$response = BlackHole::storm($response,$body);
		
		return $response;
	}
	
	
	//Оплата с привязанной карты
	public function payFromCard($body)
	{
		$check['commission'] = [];
		//Создается объект класса CardServices, в котором будет создаваться операция для оплаты с карты
		$card = new CardServices();
		
		$service = Yii::$app->service->service->oneById($body['service_id']);
		$serviceDAO = ServiceDAO::findOne(array('service_id'=>$body['service_id']));
		$body['fields']['button'] =  true;
		
		//Получаем id транзакции которая необходима для оплаты
		$check = TpsCommands::merchantCheck($service->merchant,$service->name,intval($body['service_id']),(object)$body['fields'])->send();
		$check['commission'] = $card::getCommissionBySpec($body['service_id'], $body['fields']['amount'], $card::SUBJECT_RESMI);
		$check['service_Id'] = $body['service_id'];
		
		$check['amount'] = isset($body['bodyAmount']) ? $body['bodyAmount'] : $body['fields']['amount'];
		
		//Обязательное условие передача информации имя сервиса,id, поле которое содержит в себе то что пришло
		$billingInfo = json_encode(array('serviceName'=>$service->name,'service_id'=>$body['service_id'],'fields' => $check));
	
		//Оплата с кошелька возвращается $operationId
		$operationIdPay = TpsOperations::newPayment(OperationSubType::SIMPLE, $service->merchant, floatval($body['fields']['amount']),$billingInfo,intval($body['service_id']),$body['fields']['account'])->send();
		
		
		if($serviceDAO['type'] != ServicesType::WITHDRAWAL_CARD)
		{
			if(isset($body['cardId'])){
				$operationIdCardPay = $card->createCardOperation($operationIdPay,intval($body['service_id']),floatval($body['fields']['amount']),$body['cardId']);
			}else{
				$operationIdCardPay = $card->createCardOperation($operationIdPay,intval($body['service_id']),floatval($body['fields']['amount']),$body['card_id']);
			}
		}
		
		return ['operationIdPay'=>$operationIdPay,'operationIdCardPay'=>$operationIdCardPay];
	}
	
	
	
	
	//Подтверждение оплаты с привязанной карты
	public function confirm($operationId) {
		$card = new CardServices();
		return $card->cardConfirm($operationId);
	}
	
	
	//Получение коммиссии по сервису
	public function getCommissionByService($serviceId, $amount)
	{
		//Получаем сервис по id
		$service = Yii::$app->service->service->oneById($serviceId);
		
		//Получаем коммиссию на сервис
		$commission = TpsOperations::getCommission(Yii::$app->user->identity->login, (int)$service->id, floatval($amount))->send();
		
		return $commission;
	}
	
}