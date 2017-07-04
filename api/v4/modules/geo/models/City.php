<?php
namespace api\v4\modules\geo\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class City extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%city}}';
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'date_change',
					ActiveRecord::EVENT_BEFORE_UPDATE => 'date_change',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
		];
	}
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['update'] = $scenarios['create'] =
			['id', 'id_country', 'region_id', 'city_name', 'position', 'status'];
		return $scenarios;
	}
	
	public function extraFields()
	{
		return ['country'];
	}
	
	public function rules()
	{
		return [
			[['id', 'id_country', 'city_name'], 'required', 'on' => 'create'],
			[['id', 'city_name'], 'unique'],
			[['city_name'], 'trim'],
			['city_name', 'string', 'min' => 2],
			[['id', 'id_country', 'region_id', 'position', 'status'], 'integer'],
			['id_country', 'exist', 'targetClass' => Country::className(), 'targetAttribute' => 'code', 'skipOnError' => true],
		];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCountry()
	{
		return $this->hasOne(Country::className(), ['code' => 'id_country']);
	}
}
