<?php

namespace api\v4\modules\active\models;

use yii\db\ActiveRecord;

class Fields extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%active_field}}';
	}
	
	/**
	 * @inheritdoc
	 */
	public function extraFields()
	{
		return ['validations', 'options'];
	}
	
	public function fields()
	{
		$fields = parent::fields();
		$fields['validations']= 'validations';
		$fields['options']= 'options';
		return $fields;
	}
	public static function find()
	{
		$query = parent::find();
		$query->orderBy('priority');
		return $query;
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getOptions()
	{
		return $this->hasMany(Option::className(), [
			'field_id' => 'id',
		]);
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getValidations()
	{
		return $this->hasMany(Validation::className(), [
			'field_id' => 'id',
		]);
	}
	
}
