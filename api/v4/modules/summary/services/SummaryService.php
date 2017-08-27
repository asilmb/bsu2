<?php

namespace api\v4\modules\summary\services;

use common\ddd\services\BaseService;

class SummaryService extends BaseService {
	
	protected $all;
	
	public function getId() {
		return $this->getAll()->static_id;
	}
	
	public function getUrl() {
		return $this->getAll()->url;
	}
	
	public function getModified() {
		return $this->getAll()->last_modified;
	}
	
	public function getAll() {
		if(!isset($this->all)) {
			$this->all = $this->getRepository()->findAll([]);
		}
		return $this->all;
	}
}
