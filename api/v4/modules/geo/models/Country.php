<?php
namespace api\v4\modules\geo\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Country extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%country}}';
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
		return ['currency', 'cities', 'regions'];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCurrency()
	{
		return $this->hasOne(Currency::className(), ['code' => 'code_curr']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCities()
	{
		return $this->hasMany(City::className(), ['id_country' => 'code']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRegions()
	{
		return $this->hasMany(Region::className(), ['country_id' => 'code']);
	}
}
