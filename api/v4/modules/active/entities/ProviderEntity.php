<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;

class ProviderEntity extends BaseEntity {
	
	protected $id;
	protected $title;
	protected $description;
	protected $logo;
	protected $background_color;
	protected $font_color;
	protected $bik;
	protected $api_sign;
}
