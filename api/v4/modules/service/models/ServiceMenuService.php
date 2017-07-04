<?php
namespace api\v4\modules\service\models;

use yii\db\ActiveRecord;

class ServiceMenuService extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%service_menu_service}}';
	}
	
}
