<?php

namespace api\v4\modules\transfer\repositories\tps;

use common\ddd\repositories\TpsRepository;

class DefaultRepository extends TpsRepository {
	
	public function isExistsWallet($login) {
		return true;
	}
	
	public function isExistsCard($login) {
		return true;
	}
	
}