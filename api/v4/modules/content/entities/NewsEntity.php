<?php

namespace api\v4\modules\content\entities;

use common\ddd\BaseEntity;

class NewsEntity extends BaseEntity {
	
	protected $id;
	protected $title;
	protected $description;
	protected $logo;
	protected $position;
	
}
