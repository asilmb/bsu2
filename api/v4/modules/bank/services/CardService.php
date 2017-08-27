<?php

namespace api\v4\modules\bank\services;

use api\v4\modules\bank\forms\ApproveForm;
use api\v4\modules\bank\helpers\linking\CreateActive;
use common\ddd\data\Query;
use common\ddd\helpers\ErrorCollection;
use common\ddd\interfaces\services\ModifyInterface;
use common\ddd\interfaces\services\ReadInterface;
use common\ddd\services\ActiveBaseService;
use common\exceptions\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;
use yii2woop\tps\generated\exception\tps\ExternalOperationNotPaidException;
use yii2woop\tps\generated\exception\tps\InvalidPackageStructureException;
use yii2woop\tps\generated\exception\tps\MoneyPaymentException;

class CardService extends ActiveBaseService implements ReadInterface, ModifyInterface {

	public function GetOneByReference($referenceId)
	{
		return $this->repository->findOneByReference($referenceId);
	}
	
	public function findAllApproved() {
		return $this->repository->findAllApproved();
	}
	
	public function approve($body)
	{
		$this->validateForm(ApproveForm::className(), $body);
		$entity = $this->repository->findOneByReference($body['reference']);
		$error = new ErrorCollection();
		if(empty($entity)) {
			$error->add('reference', 'bank/card', 'card_not_found');
			throw new UnprocessableEntityHttpException($error);
		}
		/*if($entity->approve === false) {
			$this->addError('reference', t('bank/card', 'card_already_approved'));
			throw new UnprocessableEntityHttpException;
		}*/
		try {
			$this->repository->approve($entity->id, $body['reference'], $body['amount']);
			CreateActive::run($entity);
		} catch (InvalidPackageStructureException $e) {
			$error->add(null, 'tps', 'InvalidPackageStructureException');
			throw new UnprocessableEntityHttpException($error);
		} catch (ExternalOperationNotPaidException $e) {
			$error->add(null, 'tps', 'ExternalOperationNotPaidException');
			throw new UnprocessableEntityHttpException($error);
		} catch (MoneyPaymentException $e) {
			$error->add(null, 'tps', 'MoneyPaymentException');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	public function attach($body) {
		
	}
}
