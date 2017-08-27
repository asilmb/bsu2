<?php

namespace api\v4\modules\service\entities;

use common\ddd\BaseEntity;

class FavoriteEntity extends BaseEntity {
	
	protected $id;
	protected $user_id;
	protected $billinginfo;
	protected $amount;
	protected $name;
	protected $status = 1;
	protected $type = 1;
	protected $position = 1;
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['name'], 'trim'],
			[['name'], 'required'],
			[['service_id', 'user_id', 'amount', 'status', 'type', 'position'], 'integer'],
		];
	}

}
