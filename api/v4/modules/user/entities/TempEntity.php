<?php

namespace api\v4\modules\user\entities;

use common\ddd\BaseEntity;

class TempEntity extends BaseEntity {

	protected $login;
	protected $email;
	protected $activation_code;
	protected $ip;
	protected $create_time;
	
}
