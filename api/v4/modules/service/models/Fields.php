<?php

namespace api\v4\modules\service\models;

use yii\db\ActiveRecord;

class Fields extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%service_field}}';
	}
	
	public function extraFields()
	{
		return ['translate', 'validations', 'values'];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTranslate()
	{
		return $this->hasOne(FieldsTranslate::className(), [
			'service_id' => 'service_id',
			'service_field_name' => 'name',
		]);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getValidations()
	{
		return $this->hasMany(FieldsValidation::className(), [
			'service_field_id' => 'service_param_id',
		]);
	}
	
	public function fields()
	{
		$fields = parent::fields();
		$fields['translate'] = 'translate';
		$fields['validations'] = 'validations';
		$fields['values'] = 'values';
		return $fields;
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getValues()
	{
		return $this->hasMany(FieldsValue::className(), [
			'service_field_id' => 'service_param_id',
		]);
	}
}
