<?php

namespace api\v4\modules\transaction\entities;

use common\ddd\BaseEntity;

class HistoryEntity extends BaseEntity {

	protected $id;
	protected $amount;
	protected $status;
	protected $description;
	protected $type;
	protected $title;
	protected $paymentAccount;
	protected $direction;
	protected $serviceId;
	protected $picture_url;
	protected $externalId;
	protected $dateOper;
	protected $dateDone;
	protected $dateModify;
	protected $reqStat;
	protected $receipt;
	protected $billingInfo;
	
	public function fieldType() {
		return [
			'receipt' => [
				'type' => ReceiptEntity::className(),
			],
		];
	}

}
