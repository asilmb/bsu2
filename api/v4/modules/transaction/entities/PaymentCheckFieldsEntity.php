<?php

namespace api\v4\modules\transaction\entities;

use common\ddd\BaseEntity;

class PaymentCheckFieldsEntity extends BaseEntity {
	
	protected $txn_id;
	protected $serviceId;
	protected $service_id;
	protected $commission;
	protected $operationId;
	
}
