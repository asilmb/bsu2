<?php

namespace api\v4\modules\service\models;

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
	
	/** todo: make insert user_id before save */
	
	public static function find() {
		return parent::find()
			->andWhere(['user_id' => Yii::$app->user->id]);
	}
	
	public function setBillinginfo($data)
	{
		$this->billinginfo = json_encode($data);
	}
	
	public function getBillinginfo()
	{
		return ArrayHelper::toArray(json_decode($this->billinginfo));
	}
	
}
