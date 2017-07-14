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
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['update'] = $scenarios['create'] =
			['code', 'name_short', 'name_full', 'symb_def2', 'symb_def3', 'code_curr'];
		return $scenarios;
	}
	
	public function extraFields()
	{
		return ['currency', 'cities'];
	}
	
	public function rules()
	{
		return [
			[['code', 'name_short', 'name_full', 'symb_def2', 'symb_def3'], 'required', 'on' => 'create'],
			[['code', 'name_short', 'name_full', 'symb_def2', 'symb_def3', 'code_curr'], 'unique'],
			[['name_short', 'name_full', 'symb_def2', 'symb_def3'], 'trim'],
			[['name_short', 'name_full', 'symb_def2', 'symb_def3'], 'string', 'min' => 2],
			[['code', 'code_curr'], 'integer'],
			//[['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id' => 'code']],
		];
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
}
