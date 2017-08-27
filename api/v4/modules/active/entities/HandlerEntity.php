<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;

class HandlerEntity extends BaseEntity {
	
	protected $id;
	protected $title;
	protected $module;
	protected $controller;
	protected $action;
	
}
