<?php

namespace api\v4\modules\content\models;

use yii\db\ActiveRecord;

class ExtraNews extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%extra_news}}';
	}
	
}
