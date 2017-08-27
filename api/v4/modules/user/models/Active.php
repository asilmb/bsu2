<?php

namespace api\v4\modules\user\models;

use api\v4\modules\active\models\Provider;
use api\v4\modules\active\models\Type;
use paulzi\jsonBehavior\JsonBehavior;
use yii\db\ActiveRecord;

class Active extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_active}}';
	}
	
	public function behaviors()
	{
		return [
			[
				'class' => JsonBehavior::className(),
				'attributes' => ['data'],
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function extraFields()
	{
		return ['active_type', 'provider'];
	}
	
	public function fields()
	{
		$fields = parent::fields();
		$fields['type']= 'type';
		$fields['provider']= 'provider';
		return $fields;
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getType()
	{
		return $this->hasOne(Type::className(), [
			'id' => 'active_id',
		]);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProvider()
	{
		return $this->hasOne(Provider::className(), [
			'id' => 'provider_id',
		]);
	}
	
}
