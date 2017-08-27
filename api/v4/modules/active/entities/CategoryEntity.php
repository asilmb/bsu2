<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;

class CategoryEntity extends BaseEntity {
	
	protected $id;
	protected $title;
	protected $description;
	protected $logo;
	protected $position;
	
}
