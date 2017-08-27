<?php

namespace api\v4\modules\geo\repositories\ar;

use common\ddd\repositories\ActiveArRepository;

class CurrencyRepository extends ActiveArRepository {
	
	public function uniqueFields() {
		return [
			['symb_def'],
		];
	}
	
}
