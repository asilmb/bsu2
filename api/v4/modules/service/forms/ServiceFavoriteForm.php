<?php

namespace api\v4\modules\service\forms;

use common\yii\base\Model;

class ServiceFavoriteForm extends Model {
	
	public $favorite_id;
	public $service_id;
	public $title;
	public $fields;
	
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['title'], 'trim'],
			[['service_id', 'fields'], 'required'],
			['service_id', 'integer'],
		];
	}
	
}
