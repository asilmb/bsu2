<?php

namespace api\v4\modules\transaction\controllers;

use api\v4\modules\service\models\ServiceDAO;
use api\v4\modules\transaction\helpers\ServicesType;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2woop\tps\generated\enums\ServicesStatus;
use yii2woop\tps\generated\exception\tps\WithdrawalInputPendingException;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;

class CardController extends Controller
{
	
	public $serviceName = 'transaction.card';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
			//'verbFilter' => [
			//	'class' => VerbFilter::className(),
			//	'actions' => $this->verbs(),
			//],
		];
	}
	
	//protected function verbs()
	//{
	//	return [
	//		'card-wrapper' => ['GET'],
	//	];
	//}
	
	public function init() {
		Yii::$app->response->format = Response::FORMAT_HTML;
		$this->layout = 'empty_for_card';
		parent::init();
	}
	
	public function actionCardWrapper($operationId = 0, $link = false, $cardId = null, $bank_id = null) {
		
		if (!empty($link)) {
			$model = $this->service->linkExists();
			return $this->render('api_frame/card_linking_frame', ['model' => $model, 'bank_id' => $bank_id]);
		} else {
			$cardOperations = TpsCommands::getOperationsData(array((int)$operationId))->send();
			$operationIdFrame = $operationId;
			if (!empty($cardOperations[0])) {
				if ($cardOperations[0]->parentId != 0) {
					$operationId = $cardOperations[0]->parentId;
				}
				if ($cardOperations[0]->serviceId) {
					$service = ServiceDAO::find()->where(['service_id' => $cardOperations[0]->serviceId, 'status' => ServicesStatus::MODERATED])->one();
					if ($service && $service->type == ServicesType::WITHDRAWAL_CARD) {
						$guid = TpsOperations::getWithdrawalOperationUuid([(int)$cardOperations[0]->id])->send();
						try {
							TpsOperations::continueWithdrawal((int)$cardOperations[0]->id, $guid[$cardOperations[0]->id])->send();
						} catch (WithdrawalInputPendingException $e) {
							return $this->render('api_frame/withdrawal_card_frame', ['inputUrl' => $e->inputUrl]);
						}
					} else {
						$model = BaseCardOperation::getModelForOperation((int)$operationId, $cardId);
						return $this->render('api_frame/card_frame',['model' => $model,'cardId'=>$cardId,'operationId'=>$operationId,'operationIdFrame'=>$operationIdFrame]);
					}
				}
			} else {
				throw new NotFoundHttpException();
			}
		}
	}

}
