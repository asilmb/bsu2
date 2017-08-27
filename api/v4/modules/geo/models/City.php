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
	
	public function extraFields()
	{
		return ['country', 'region'];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCountry()
	{
		return $this->hasOne(Country::className(), ['code' => 'id_country']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRegion()
	{
		return $this->hasOne(Region::className(), ['id' => 'region_id']);
	}
}
