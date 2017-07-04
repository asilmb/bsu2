<?php

namespace api\v4\modules\card\services\card;

use common\services\BaseRepository;

class Repository extends BaseRepository {
	
	public function withBank() {
		$this->with('bank');
	}

}