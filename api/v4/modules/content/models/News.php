<?php

namespace api\v4\modules\content\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%active_category}}';
	}
	
}
