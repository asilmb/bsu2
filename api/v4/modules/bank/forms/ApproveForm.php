<?php
namespace api\v4\modules\bank\forms;

use Yii;
use yii2lab\misc\yii\base\Model;

/**
 * Login form
 */
class ApproveForm extends Model
{
	public $reference;
	public $amount;
   
	public function rules()
	{
		return [
			[['reference', 'amount'], 'required'],
			['amount', 'double', 'numberPattern' => '/^[0-9]{2}\.[0-9]+$/', 'message' => t('bank/card', 'valid_float')],
			//['amount', 'number', ],
			['reference', 'integer', 'min' => '1000000'],
		];
	}
	
}
