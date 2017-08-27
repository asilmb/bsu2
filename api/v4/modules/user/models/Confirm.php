<?php

namespace api\v4\modules\user\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Confirm model
 *
 * @property string $login
 * @property string $action
 * @property string $activation_code
 * @property string $created_at
 */
class Confirm extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_confirm}}';
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
					//ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
		];
	}
	
}
