<?php

namespace api\v4\modules\summary\entities;

use common\ddd\BaseEntity;

class SummaryEntity extends BaseEntity {

	protected $static_id;
	protected $url;
	protected $last_modified;
	
	function getStaticId() {
		return $this->static_id;
	}
	
	function getUrl() {
		return $this->url;
	}
	
	function getLastModified() {
		return $this->last_modified;
	}
	
}
