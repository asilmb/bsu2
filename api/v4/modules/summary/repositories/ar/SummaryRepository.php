<?php

namespace api\v4\modules\summary\repositories\ar;

use api\v4\modules\summary\helpers\ResourceHelper;
use api\v4\modules\summary\entities\UrlEntity;
use api\v4\modules\summary\entities\LastModifiedEntity;
use api\v4\modules\summary\entities\StaticIdEntity;
use api\v4\modules\summary\entities\SummaryEntity;

class SummaryRepository {

	public function findAll() {
		$all = ResourceHelper::getTree();
		$summary['url'] = new UrlEntity($all['url']);
		$summary['static_id'] = new StaticIdEntity($all['static_id']);
		$summary['last_modified'] = new LastModifiedEntity($all['last_modified']);
		$su = new SummaryEntity($summary);
		return $su;
	}

}