<?php

namespace api\v4\modules\transaction\forms;

use yii2lab\misc\yii\base\Model;

/**
 * Login form
 */
class CommissionForm extends Model
{
	public $service_id;
	public $amount;
   
	public function rules()
	{
		return [
			[['service_id', 'amount'], 'required'],
			['service_id', 'integer'],
			['amount', 'double'],
		];
	}
	
}
