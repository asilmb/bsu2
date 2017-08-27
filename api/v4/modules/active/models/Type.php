<?php

namespace api\v4\modules\active\models;

use yii\db\ActiveRecord;

class Type extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%active}}';
	}
	
	/**
	 * @inheritdoc
	 */
	public function extraFields()
	{
		return ['fields'];
	}
	public function fields()
	{
		$fields = parent::fields();
		$fields['fields']= 'fields';
		return $fields;
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFields()
	{
		return $this->hasMany(Fields::className(), [
			'active_id' => 'id',
		]);
	}
}
