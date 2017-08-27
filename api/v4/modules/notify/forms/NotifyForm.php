<?php

namespace api\v4\modules\notify\forms;

use common\yii\base\Model;

class NotifyForm extends Model
{
	
	public $type;
	public $subject;
	public $message;
	public $address;
	
	public function rules()
	{
		return [
			[['type', 'subject', 'message', 'address'], 'trim'],
			[['type', 'message', 'address'], 'required'],
			['type', 'in', 'range' => ['sms', 'email', 'site']],
		];
	}
	
}
