<?php

namespace api\v4\modules\transaction\services;

use common\ddd\services\ActiveBaseService;
use yii\web\NotFoundHttpException;
use common\ddd\data\Query;
use yii2woop\tps\generated\enums\OperationStatus;
use yii2woop\tps\generated\enums\OperationType;

class HistoryService extends ActiveBaseService
{
	
	public function findOne($id, $params = []) {
		$item = $this->repository->findOne($id);
		if(empty($item)) {
			throw new NotFoundHttpException();
		}
		return $item;
	}
	
	public function getDataProvider(Query $query = null) {
		return $this->repository->findAll($query)->getDataProvider();
	}
	
	public function getDataProvider2(Query $query = null) {
		
		return $this->repository->all($query)->getDataProvider();
	}
	
	static function getOperationTypes() {
		return [
			OperationType::UNKNOWN => 'неизвестный',
			//OperationType::DIVIDED => 'разделенный',
			OperationType::EMISSION => 'эмиссия',
			OperationType::TRANSFER => 'перевод',
			OperationType::TRANSFER_EVENT => 'передача',
			OperationType::TRANSFER_DREAM => 'перевод DREAM',
			OperationType::TRANSFER_SUBAGENT => 'перевод субагенту',
			OperationType::TRANSFER_DONATE => 'перевод donate',
			OperationType::TRANSFER_AGENT => 'перевод агенту',
			OperationType::TRANSFER_ADDRESSLESS => 'безадресный перевод',
			OperationType::TRANSFER_TRANSIT => 'транзитный перевод',
			OperationType::TRANSFER_WSDL => 'перевод WSDL',
			OperationType::TRANSFER_SALE_WSDL => 'продажа WSDL',
			OperationType::TRANSFER_DONATE_WSDL => 'перевод DONATE_WSDL',
			OperationType::TRANSFER_AGENT_WSDL => 'перевод агенту WSDL',
			OperationType::PAYMENT => 'оплата',
			OperationType::PAYMENT_DREAM => 'оплата DREAM',
			OperationType::PAYMENT_REQUEST => 'запрос оплаты',
			OperationType::INVOICE => 'инвойс',
			OperationType::PAYMENT_PREPAID => 'предоплата',
			OperationType::PAYMENT_DELAYED => 'задержанная оплата',
			OperationType::PAYMENT_TRANSIT => 'транзитная оплата',
			OperationType::PAYMENT_WSDL => 'оплата WSDL',
			OperationType::INVOICE_WSDL => 'инвойс WSDL',
			OperationType::INVOICE_SMS => 'инвойс SMS',
			OperationType::CASHING => 'вывод',
			OperationType::SWAP => 'обмен',
			OperationType::DISCHARGEMENT => 'DISCHARGEMENT',
			OperationType::GENERAL_RETURN => 'возврат',
			OperationType::MERCHANT_RETURN => 'возврат мерчанта',
			OperationType::RETURN_PART_OF_OPERATION => 'возврат части операции',
			OperationType::CONFIRMATION => 'подтверждение',
			OperationType::ALL => 'ALL'
		];
	}
	
	static function getOperationStates() {
		return [
			OperationStatus::CREATED => 'создан',
			OperationStatus::CONFIRMED => 'подтвержден',
			OperationStatus::REJECTED => 'отклонен',
			OperationStatus::FINISHED => 'завершен',
			OperationStatus::CANCELLED => 'отменен',
			OperationStatus::STORNING => 'STORNING',
			OperationStatus::DELETED => 'удален',
			OperationStatus::KVITED => 'KVITED',
			OperationStatus::MERCHANT_WAITING => 'ожидающий',
			OperationStatus::DELETED_VISIBLE => 'DELETED_VISIBLE'
		];
	}
}
