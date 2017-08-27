<?php
namespace api\v4\modules\convertation\helpers;
use api\v4\modules\transaction\helpers\CardServices;
use Exception;
use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\enums\OperationSubType;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;

/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 11.08.2017
 * Time: 16:05
 */
class Convertation {
	
	public function convertationCardToAccount($params){
		$baseCard = BaseCardOperation::getModel(param('AcquiringAccess'),param('AcquiringType'));
		$card = new CardServices();
		
		$data = TpsOperations::newLinkedCard((float)$params['amount'],CardServices::CARD_TYPE_RESMI,AcquiringType::RESMI_WOOPPAY_LINKED,OperationSubType::SIMPLE,strval($params['card_id']))->send();
		
		if (is_array($data)) {
			$operationId = $data['operationId'];
			$baseCard->setSign($data['document']);
			$baseCard->setApproveSign($data['document']);
		} else {
			$operationId = $data;
		}
		$baseCard->setOperationId($operationId);
		$operation = TpsCommands::getOperationsData(array($operationId))->send();
		if (!empty($operation)) {
			$card->updatePendingReplanishmentCount();
			return $baseCard->getOperationId();
			
		} else {
			try {
				TpsOperations::cancel(array($baseCard->getOperationId()))->send();
			} catch (Exception $e) {
				//nothing to do here
			}
			return false;
		}
	}
}