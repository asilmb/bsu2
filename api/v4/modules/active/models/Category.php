<?php

namespace api\v4\modules\active\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%active_category}}';
	}
	
}
