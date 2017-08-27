<?php
namespace api\v4\modules\geo\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Region extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%region}}';
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
	
	public function extraFields()
	{
		return ['country', 'cities'];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCountry()
	{
		return $this->hasOne(Country::className(), ['code' => 'country_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCities()
	{
		return $this->hasMany(City::className(), ['region_id' => 'id']);
	}
	
}
