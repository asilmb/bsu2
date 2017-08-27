<?php

namespace api\v4\modules\bank\helpers\linking;

use api\v4\modules\bank\entities\CardEntity;
use api\v4\modules\user\entities\ActiveEntity;
use frontend\modules\bank\dto\CardDataTransfer;
use Yii;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;

/**
 * @var $data CardDataTransfer
 * @var $model WooppayCardLinkOperation
 * @var $model EpayCardLinkOperation
 */
class CreateActive {
	//todo очень сыро. Понадобидтся следующие функции:
	public static function run(CardEntity $cardEntity) {
		$model = new ActiveEntity();
		$data['expire_date'] = '2017-07-20';
		$data['card_id'] = $cardEntity->id;
		$data['currency_amount'] = 'kzt:0;usd:0;usd:0;';
		$data['username'] = 'fghfgh';
		$data['mask'] = substr($cardEntity->mask, 0, 4) . '-****-****-' . substr($cardEntity->mask, 15, 4);;
		$data['title'] = 'my_card';
		$data['multi_currency'] = false;
		$model->user_id =  Yii::$app->account->auth->identity->id;
		$model->active_id = 1;
		$model->provider_id = $cardEntity->bank->id;
		$model->currency_code = 1;
		$model->data = $data;
		Yii::$app->account->active->createData($model);
	}
}