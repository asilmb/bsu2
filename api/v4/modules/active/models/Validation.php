<?php

namespace api\v4\modules\active\models;

use paulzi\jsonBehavior\JsonBehavior;
use yii\db\ActiveRecord;

class Validation extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%active_field_validation}}';
	}
	
	public function behaviors()
	{
		return [
			[
				'class' => JsonBehavior::className(),
				'attributes' => ['rules'],
			],
		];
	}
	
}
