<?php
namespace api\v4\modules\service\models;

use yii\db\ActiveRecord;

class FieldsValidation extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%service_field_validation}}';
	}
	
}