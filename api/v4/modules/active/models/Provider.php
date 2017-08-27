<?php

namespace api\v4\modules\active\models;

use yii\db\ActiveRecord;

class Provider extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%active_provider}}';
	}
	
}
