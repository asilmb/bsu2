<?php

namespace api\v4\modules\bank\helpers\linking;

use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;


class CardFactory {
	
	public static function createCard() {
		$model = self::createModel();
		if (BaseCardOperation::isHbpay()) {
			$card = TpsOperations::newCardLinking($model::getAcquiringTerminal(), AcquiringType::HBPAY)->send();
		} else {
			$card = TpsOperations::newCardLinking($model::getAcquiringTerminal(), AcquiringType::WOOPPAY_LINKED)->send();
		}
		return $card;
	}
	
	public static function createModel() {
		if (BaseCardOperation::isHbpay()) {
			$model = new EpayCardLinkOperation();
		} else {
			$model = new WooppayCardLinkOperation();
		}
		return $model;
	}
}
