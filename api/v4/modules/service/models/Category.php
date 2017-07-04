<?php
namespace api\v4\modules\service\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%service_menu}}';
	}
	
}
