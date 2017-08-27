<?php

namespace api\v4\modules\service\models;

use paulzi\jsonBehavior\JsonBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Favorite extends ActiveRecord 
{
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%favorite}}';
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
			'blameable' => [
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'user_id',
				'updatedByAttribute' => 'user_id',
			],
			'rulesJson' => [
				'class' => JsonBehavior::className(),
				'attributes' => ['billinginfo'],
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
		];
	}
	
	/*public function fields()
	{
		$fields = parent::fields();
		$fields['service']= 'service';
		return $fields;
	}*/
	
	/** todo: make insert user_id before save */
	
	public static function find() {
		return parent::find()
			->andWhere(['user_id' => Yii::$app->user->id]);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	/*public function getService()
	{
		return $this->hasOne(Service::className(), [
			'field_id' => 'id',
		]);
	}*/
}
