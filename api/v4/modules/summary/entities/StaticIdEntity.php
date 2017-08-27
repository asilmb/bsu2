<?php

namespace api\v4\modules\summary\entities;

use common\ddd\BaseEntity;

class StaticIdEntity extends BaseEntity {

	protected $category_root;
	protected $addressless_transfer;
	protected $cnp_withdrawal;
	protected $iban_payment;
	
}
