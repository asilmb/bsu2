<?php

namespace api\v4\modules\transaction\services;

use api\v4\modules\transaction\forms\CommissionForm;
use api\v4\modules\transaction\forms\PaymentForm;
use api\v4\modules\transaction\forms\ApiPaymentRequest;
use common\ddd\services\BaseService;
use common\ddd\helpers\ErrorCollection;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\exception\tps\NoCommissionException;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;

class CardService extends BaseService
{
	
	public function linkExists() {
		if (BaseCardOperation::isHbpay()) {
			$model = new EpayCardLinkOperation();
			$result = TpsOperations::newCardLinking($model::getAcquiringTerminal(), AcquiringType::RESMI_HBPAY)->send();
		} else {
			$model = new WooppayCardLinkOperation();
			$result = TpsOperations::newCardLinking($model::getAcquiringTerminal(), AcquiringType::RESMI_WOOPPAY_LINKED)->send();
		}
		$model->setSign($result['document']);
		return $model;
	}
	
}
