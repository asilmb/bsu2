<?php

namespace api\v4\modules\convertation\repositories\tps;

use api\v4\modules\service\models\ServiceDAO;
use api\v4\modules\transaction\helpers\CardServices;
use api\v4\modules\transaction\helpers\ServicesType;

use common\ddd\BaseRepository;
use api\v4\modules\convertation\helpers\Convertation;
use common\ddd\repositories\TpsRepository;
use common\exceptions\UnprocessableEntityHttpException;
use Exception;
use yii\helpers\Url;
use Yii;
use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\enums\OperationSubType;
use yii2woop\tps\generated\enums\OperationType;
use yii2woop\tps\generated\exception\tps\NotAuthenticatedException;
use yii2woop\tps\generated\request\operation\money\NewWithdrawalOperationRequest;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;

class ConvertationRepository extends TpsRepository {
	
	const SERVICE_FOR_ACCOUNT_TO_ACCOUNT = 370;
	const SERVICE_FOR_ACCOUNT_TO_EMAIL = 306;
	const SERVICE_FOR_CARD_TO_ACCOUNT = 1397;
	const SERVICE_FOR_ACCOUNT_TO_CARD = 1393;
	
	public function accountToAccount($params = null) {
		try {
			$operationId = TpsOperations::newTransfer(OperationSubType::SIMPLE, $params['account'], floatval($params['amount']), null, self::SERVICE_FOR_ACCOUNT_TO_ACCOUNT)->send();
			$result = TpsOperations::confirm($operationId)->send();
		}catch(NotAuthenticatedException $e) {
			\Yii::$app->account->auth->breakSession();
			//$this->redirect('/');
		}
		
		return ['operationId'=>$operationId];
	}
	
	
	//Оплата с привязанной карты на кошелек
	public function cardToAccount($params = null) {
		$card = new Convertation();
		$params['service_id'] = self::SERVICE_FOR_CARD_TO_ACCOUNT;
		$operationId = $card->convertationCardToAccount($params);
		$body['operationId'] = $operationId;
		try{
			$confirm = Yii::$app->transaction->payment->confirm($body);
		}catch(UnprocessableEntityHttpException $e){
			$e->getMessage();
		}
		if($confirm['success']){
			return ['operationId'=>$operationId];
		}else{
			return ['operationId'=>null];
		}
		
	}
		
	
	public function  accountToCard($body) {
		
		$card = new CardServices();
		
		$service = Yii::$app->service->service->oneById($body['service_id']);
		$serviceDAO = ServiceDAO::findOne(array('service_id'=>$body['service_id']));
		$body['fields']['button'] =  true;
		
		//Получаем id транзакции которая необходима для оплаты
		//$check = TpsCommands::merchantCheck('',null,intval($body['service_id']),(object)$body['fields']['amount'])->send();
	
		$check['commission'] = $card::getCommissionBySpec($body['service_id'], $body['fields']['amount'], $card::SUBJECT_RESMI);
		$check['service_Id'] = $body['service_id'];
		$check['amount'] = $body['fields']['amount'];
		$check['txn_id'] = '';
		$check = ['fields'=>['commission'=>$check['commission'],'amount'=>$check['amount'],'txn_id'=>$check['txn_id'] ],'service_id'=>$check['service_Id']];
		//Обязательное условие передача информации имя сервиса,id, поле которое содержит в себе то что пришло
		$billingInfo = json_encode(array('serviceName'=>$service->name,'service_id'=>$body['service_id'],'fields' => $check));
		
		if($service->merchant != Yii::$app->user->identity->login) {
			
			//Оплата с кошелька возвращается $operationId
			$operationIdPay = TpsOperations::newWithdrawal(floatval($body['fields']['amount']), OperationSubType::SIMPLE, intval($card->getTerminalType(true)), intval($body['service_id']),Url::to(['/']),strval($card::SUBJECT_RESMI),null,null,$billingInfo,null,strval($body['fields']['account']))->send();
		}
		
		
			if(isset($body['cardId'])){
				$operationIdCardPay = $card->createCardOperation(isset($operationIdPay) ? $operationIdPay : null,intval($body['service_id']),floatval($body['fields']['amount']),$body['cardId']);
			}else{
				$operationIdCardPay = $card->createCardOperation(isset($operationIdPay) ? $operationIdPay : null,intval($body['service_id']),floatval($body['fields']['amount']),$body['card_id']);
			}

		return ['operationIdPay'=>$operationIdPay,'operationIdCardPay'=>$operationIdCardPay];
	}
	
	
}