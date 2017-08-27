<?php

namespace api\v4\modules\bank\controllers;

use api\v4\modules\bank\helpers\linking\CardFactory;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2woop\tps\generated\enums\ServicesStatus;
use yii2woop\tps\generated\enums\ServicesType;
use yii2woop\tps\generated\exception\tps\WithdrawalInputPendingException;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;


class FrameController extends Controller {
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
		];
	}
	
	public function init() {
		Yii::$app->response->format = Response::FORMAT_HTML;
		$this->layout = 'empty_for_card';
		parent::init();
	}
	
	public function actionAttach($operationId = 0, $link = false, $cardId = null) {
		if (!empty($link)) {
			$model= CardFactory::createModel();
			$card = CardFactory::createCard();
			
			$model->setSign($card['document']);
			
			return $this->render('api_frame/card_linking_frame', ['model' => $model]);
		} else {
			//оплата
			$cardOperations = TpsCommands::getOperationsData([(int) $operationId])->send();
			if (!empty($cardOperations[0])) {
				if ($cardOperations[0]->parentId != 0) {
					$operationId = $cardOperations[0]->parentId;
				}
				if ($cardOperations[0]->serviceId) {
					$service = ServiceDTO::model()->findByAttributes([
						'service_id' => $cardOperations[0]->serviceId,
						'status' => ServicesStatus::MODERATED,
					]);
					if ($service && $service->type == ServicesType::WITHDRAWAL_CARD) {
						$guid = TpsOperations::getWithdrawalOperationUuid([(int) $cardOperations[0]->id])->send();
						try {
							TpsOperations::continueWithdrawal((int) $cardOperations[0]->id, $guid[ $cardOperations[0]->id ])->send();
						} catch (WithdrawalInputPendingException $e) {
							return $this->render('api_frame/withdrawal_card_frame', ['inputUrl' => $e->inputUrl]);
						}
					} else {
						$model = BaseCardOperation::getModelForOperation((int) $operationId, $cardId);
						return $this->render('api_frame/card_frame', ['model' => $model]);
					}
				}
			} else {
				throw new NotFoundHttpException();
			}
		}
	}
}
