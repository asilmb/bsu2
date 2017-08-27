<?php

namespace api\v4\modules\geo\repositories\ar;

use common\ddd\repositories\ActiveArRepository;

class CountryRepository extends ActiveArRepository {
	
	public function uniqueFields() {
		return [
			['name_short', 'name_full', 'symb_def2', 'symb_def3', 'code_curr'],
		];
	}
	
}
