<?php

namespace api\v4\modules\bank\helpers\linking;

use api\v4\modules\bank\entities\CardEntity;
use common\exceptions\UnprocessableEntityHttpException;
use frontend\modules\bank\dto\CardDataTransfer;
use frontend\modules\bank\forms\CardForm;
use Yii;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;

/**
 * @var $data CardDataTransfer
 * @var $model WooppayCardLinkOperation
 * @var $model EpayCardLinkOperation
 */
class ApproveCardLink {
	public static function run(CardEntity $cardEntity, CardDataTransfer $data) {
		if ($cardEntity->approve === false) {
			//$message = t('bank/card', 'card_success_approved {card_mask}', ['card_mask' => $cardEntity->mask]);
			//Yii::$app->notify->transport->sendEmail(Yii::$app->user->identity->email, '', $message);
			//Yii::$app->notify->transport->sendSms(Yii::$app->user->identity->login, $message);
			CreateActive::run($cardEntity);
			return true;
		}
		$body = Yii::$app->request->getBodyParam('CardForm');
		if (empty($body)) {
			return false;
		}
		$body['reference'] = $cardEntity->reference;
		$form = $data->form;
		$form->setScenario(CardForm::SCENARIO_AMOUNT);
		$form->load($body, '');
		
		// Если заполнено верно, пробуем подтвердить привязку
		if (!$form->validate()) {
			throw new UnprocessableEntityHttpException($form->getErrors());
		}
		try {
			Yii::$app->bank->card->approve($body);
			return true;
		} catch (UnprocessableEntityHttpException $e) {
			$form->addErrorsFromException($e);
		}
		return false;
	}
}