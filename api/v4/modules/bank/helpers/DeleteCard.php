<?php

namespace api\v4\modules\bank\helpers;

use common\ddd\data\Query;
use frontend\modules\bank\dto\CardDataTransfer;
use Yii;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;

/**
 * @var $data CardDataTransfer
 * @var $model WooppayCardLinkOperation
 * @var $model EpayCardLinkOperation
 */
class DeleteCard {
	//todo очень сыро. Понадобидтся следующие функции:
	public static function run($id) {
		$query = new Query();
		$user_actives = Yii::$app->account->active->all();
		foreach ($user_actives as $user_active) {
			if($user_active->data['card_id'] == $id){
				Yii::$app->account->active->deleteById($user_active->id);
				
			}
		}
		Yii::$app->bank->card->deleteById($id);
	}
}