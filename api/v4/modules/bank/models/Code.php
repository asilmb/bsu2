<?php
namespace api\v4\modules\bank\models;

use yii\db\ActiveRecord;

class Code extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%bank_code}}';
	}
	
}
