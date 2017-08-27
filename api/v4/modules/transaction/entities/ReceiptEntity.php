<?php

namespace api\v4\modules\transaction\entities;

use common\ddd\BaseEntity;

class ReceiptEntity extends BaseEntity {

	protected $subjectFrom;
	protected $subjectFromLastName;
	protected $subjectTo;
	protected $subjectToId;
	protected $specialistId;
	protected $specialist;
	protected $specialistLastName;
	protected $commission;
	protected $amount;

}
