<?php

namespace api\v4\modules\transaction\forms;

use yii2lab\misc\yii\base\Model;

/**
 * Login form
 */
class PaymentForm extends Model
{
	public $service_id;
	public $fields;
   
	public function rules()
	{
		return [
			[['service_id', 'fields'], 'required'],
			['service_id', 'integer'],
		];
	}
	
}
